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
        ]);

        if (isset($data['allergens']) && is_array($data['allergens'])) {
            $data['allergens'] = implode(', ', $data['allergens']);
        }
        if (isset($data['dietary']) && is_array($data['dietary'])) {
            $data['dietary'] = implode(', ', $data['dietary']);
        }

        $data['emergency'] = filter_var($request->input('emergency'), FILTER_VALIDATE_BOOLEAN);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
