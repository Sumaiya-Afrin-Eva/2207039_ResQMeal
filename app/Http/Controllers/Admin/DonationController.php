<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with('donor')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.donations.index', compact('donations'));
    }

    public function create()
    {
        return view('admin.donations.create');
    }

    public function checkDonor($id)
    {
        $donor = Donor::where('id', $id)->first();
        if ($donor) {
            return response()->json([
                'exists' => true,
                'name' => $donor->first_name . ' ' . $donor->last_name
            ]);
        }
        return response()->json(['exists' => false]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'food_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'unit' => 'required|string|max:50',
            'serves' => 'required|integer',
            'expiry' => 'required|date',
            'pickup_from' => 'required|date',
            'pickup_to' => 'required|date',
            'pickup_address' => 'required|string',
            'pickup_contact' => 'required|string|max:255',
            'storage' => 'nullable|string',
            'packaging' => 'nullable|string',
            'allergens' => 'nullable|string',
            'dietary' => 'nullable|string',
            'notes' => 'nullable|string',
            'visibility' => 'required|boolean',
            'emergency' => 'required|boolean',
            
            // Hidden donor name field populated by JS
            'donor_name' => 'nullable|string|max:255',

            // Existing Donor ID
            'donor_id' => 'nullable|exists:donor,id',
            
            // New Donor Info (required if donor_id is not present)
            'first_name' => 'required_without:donor_id|string|max:255|nullable',
            'last_name' => 'required_without:donor_id|string|max:255|nullable',
            'email' => 'required_without:donor_id|email|unique:donor,email|nullable',
            'phone' => 'required_without:donor_id|string|max:255|nullable',
            'organisation' => 'nullable|string|max:255',
            'city' => 'required_without:donor_id|string|max:255|nullable',
            'donor_type' => 'required_without:donor_id|in:individual,restaurant,event,other|nullable',
            'password' => 'required_without:donor_id|string|min:8|nullable',
        ]);

        if (empty($validated['donor_id'])) {
            // Register new donor
            // Note: The PL/SQL trigger `increment_donor_id_trigger` handles the auto-increment dynamically if needed
            $donor = Donor::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'organisation' => $validated['organisation'],
                'city' => $validated['city'],
                'donor_type' => $validated['donor_type'],
                'password' => Hash::make($validated['password']),
                'is_verified' => true, // Auto-verify admin-created donors
            ]);
            $validated['donor_id'] = $donor->id;
            $validated['donor_name'] = $donor->first_name . ' ' . $donor->last_name;
        }

        Donation::create($validated);

        return redirect()->route('admin.donations')->with('success', 'Donation created successfully.');
    }

    public function edit($id)
    {
        $donation = Donation::findOrFail($id);
        return view('admin.donations.edit', compact('donation'));
    }

    public function update(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);

        $validated = $request->validate([
            'food_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'unit' => 'required|string|max:50',
            'serves' => 'required|integer',
            'expiry' => 'required|date',
            'pickup_from' => 'required|date',
            'pickup_to' => 'required|date',
            'pickup_address' => 'required|string',
            'pickup_contact' => 'required|string|max:255',
            'storage' => 'nullable|string',
            'packaging' => 'nullable|string',
            'allergens' => 'nullable|string',
            'dietary' => 'nullable|string',
            'notes' => 'nullable|string',
            'visibility' => 'required|boolean',
            'emergency' => 'required|boolean',
            
            // Hidden donor name field populated by JS
            'donor_name' => 'nullable|string|max:255',

            // Existing Donor ID
            'donor_id' => 'nullable|exists:donor,id',
        ]);

        $donation->update($validated);

        return redirect()->route('admin.donations')->with('success', 'Donation updated successfully.');
    }

    public function destroy($id)
    {
        $donation = Donation::findOrFail($id);
        
        // Optionally delete the photo if it exists
        if ($donation->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($donation->image_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($donation->image_path);
        }
        
        $donation->delete();

        return redirect()->route('admin.donations')->with('success', 'Donation deleted successfully.');
    }
}
