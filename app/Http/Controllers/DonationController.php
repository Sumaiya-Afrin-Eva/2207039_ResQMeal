<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'food_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string|max:50',
            'serves' => 'required|integer|min:1',
            'expiry' => 'required|date',
            'pickup_from' => 'required|date',
            'pickup_to' => 'required|date',
            'pickup_address' => 'required|string|max:255',
            'pickup_contact' => 'required|string|max:255',
            'storage' => 'required|string|max:255',
            'packaging' => 'required|string|max:255',
            'allergens' => 'nullable',
            'dietary' => 'nullable',
            'notes' => 'nullable|string',
            'visibility' => 'required|string|max:255',
            'emergency' => 'nullable',
            'donor_name' => 'nullable|string|max:255',
            'donor_id' => 'nullable|integer|exists:donor,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB Max
        ]);

        if (isset($data['allergens']) && is_array($data['allergens'])) {
            $data['allergens'] = implode(', ', $data['allergens']);
        }
        if (isset($data['dietary']) && is_array($data['dietary'])) {
            $data['dietary'] = implode(', ', $data['dietary']);
        }

        $data['emergency'] = filter_var($request->input('emergency'), FILTER_VALIDATE_BOOLEAN);

        // Fallback for stale sessions that don't have donor_id but have donor_email
        if (empty($data['donor_id']) && $request->has('donor_email')) {
            $donor = \App\Models\Donor::where('email', $request->input('donor_email'))->first();
            if ($donor) {
                $data['donor_id'] = $donor->id;
            }
        }
        // Handle File Upload
        if ($request->hasFile('photo')) {
            // Save in storage/app/public/donations
            $path = $request->file('photo')->store('donations', 'public');
            $data['image_path'] = $path;
        }

        $donation = Donation::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Donation posted successfully!',
            'donation' => $donation,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $donation = Donation::findOrFail($id);

        // ── Smart Food Matching Logic ──
        // Step 1: Extract city from pickup_address (last comma-separated part)
        $city = null;
        if (!empty($donation->pickup_address)) {
            $parts = explode(',', $donation->pickup_address);
            $city = trim(end($parts));
        }

        // Step 2: Fetch ALL NGOs and score each one
        $allNgos = \App\Models\NGOVolunteer::all();
        $scoredNgos = $allNgos->map(function ($ngo) use ($donation, $city) {
            $score = 0;

            // +50 points: Same city proximity
            if ($city && stripos($ngo->city, $city) !== false) {
                $score += 50;
            }

            // +30 points: High-need receiver types get priority
            $highPriorityTypes = ['orphanage', 'shelter', 'disaster'];
            if (in_array(strtolower($ngo->receiver_type ?? ''), $highPriorityTypes)) {
                $score += 30;
            }

            // +20 points: Dietary alignment (halal donors match halal NGOs etc.)
            $donationDietary = strtolower($donation->dietary ?? '');
            $ngoType = strtolower($ngo->receiver_type ?? '');
            if (!empty($donationDietary) && str_contains($donationDietary, 'halal') && str_contains($ngoType, 'mosque')) {
                $score += 20;
            } elseif (!empty($donationDietary)) {
                $score += 10; // partial dietary match
            }

            $ngo->match_score = $score;
            $ngo->is_priority = in_array(strtolower($ngo->receiver_type ?? ''), $highPriorityTypes);
            return $ngo;
        });

        // Step 3: Sort by score descending, take top 3
        $matchedNgos = $scoredNgos->sortByDesc('match_score')->take(3)->values();

        return view('donation-details', compact('donation', 'matchedNgos'));
    }

    public function history(Request $request)
    {
        $request->validate([
            'donor_id' => 'required|integer|exists:donor,id'
        ]);

        $donations = Donation::where('donor_id', $request->donor_id)
                        ->latest()
                        ->get();
                        
        return response()->json([
            'success' => true,
            'donations' => $donations
        ]);
    }

    public function matchedNgos(string $id)
    {
        $donation = Donation::findOrFail($id);

        $city = null;
        if (!empty($donation->pickup_address)) {
            $parts = explode(',', $donation->pickup_address);
            $city = trim(end($parts));
        }

        $allNgos = \App\Models\NGOVolunteer::all();
        $scoredNgos = $allNgos->map(function ($ngo) use ($donation, $city) {
            $score = 0;

            if ($city && stripos($ngo->city, $city) !== false) {
                $score += 50;
            }

            $highPriorityTypes = ['orphanage', 'shelter', 'disaster'];
            if (in_array(strtolower($ngo->receiver_type ?? ''), $highPriorityTypes)) {
                $score += 30;
            }

            $donationDietary = strtolower($donation->dietary ?? '');
            $ngoType = strtolower($ngo->receiver_type ?? '');
            if (!empty($donationDietary) && str_contains($donationDietary, 'halal') && str_contains($ngoType, 'mosque')) {
                $score += 20;
            } elseif (!empty($donationDietary)) {
                $score += 10;
            }

            $isPriority = in_array(strtolower($ngo->receiver_type ?? ''), $highPriorityTypes);
            return [
                'name'        => $ngo->organisation ?? ($ngo->first_name . ' ' . $ngo->last_name),
                'city'        => $ngo->city ?? 'N/A',
                'type'        => ucfirst($ngo->receiver_type ?? 'NGO'),
                'match_score' => $score,
                'is_priority' => $isPriority,
            ];
        });

        $matched = $scoredNgos->sortByDesc('match_score')->take(3)->values();

        return response()->json(['success' => true, 'matched' => $matched]);
    }

    public function apiShow(string $id)
    {
        $donation = Donation::findOrFail($id);
        return response()->json([
            'success' => true,
            'donation' => $donation
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $donation = Donation::findOrFail($id);

        $data = $request->validate([
            'food_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string|max:50',
            'serves' => 'required|integer|min:1',
            'expiry' => 'required|date',
            'pickup_from' => 'required|date',
            'pickup_to' => 'required|date',
            'pickup_address' => 'required|string|max:255',
            'pickup_contact' => 'required|string|max:255',
            'storage' => 'required|string|max:255',
            'packaging' => 'required|string|max:255',
            'allergens' => 'nullable',
            'dietary' => 'nullable',
            'notes' => 'nullable|string',
            'visibility' => 'required|string|max:255',
            'emergency' => 'nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB Max
        ]);

        if (isset($data['allergens']) && is_array($data['allergens'])) {
            $data['allergens'] = implode(', ', $data['allergens']);
        }
        if (isset($data['dietary']) && is_array($data['dietary'])) {
            $data['dietary'] = implode(', ', $data['dietary']);
        }

        $data['emergency'] = filter_var($request->input('emergency'), FILTER_VALIDATE_BOOLEAN);

        // Handle File Upload on Update
        if ($request->hasFile('photo')) {
            // Optionally delete the old photo
            if ($donation->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($donation->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($donation->image_path);
            }
            // Save in storage/app/public/donations
            $path = $request->file('photo')->store('donations', 'public');
            $data['image_path'] = $path;
        }

        $donation->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Donation updated successfully',
            'donation' => $donation
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Donation removed successfully'
        ]);
    }
}
