<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodRequest;
use App\Models\Donation;
use App\Models\DonorResponse;

class FoodRequestController extends Controller
{
    /** Show the request form for a specific donation */
    public function create(Request $request)
    {
        $donation = null;
        if ($request->has('donation_id')) {
            $donation = Donation::find($request->donation_id);
        }
        return view('request', compact('donation'));
    }

    /** Store a new food request in the database */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'donation_id'          => 'nullable|integer',
            'requester_name'       => 'required|string|max:200',
            'requester_email'      => 'required|email',
            'requester_phone'      => 'required|string|max:20',
            'organisation'         => 'nullable|string|max:200',
            'receiver_type'        => 'required|in:ngo,volunteer,shelter',
            'requester_city'       => 'required|string|max:100',
            'requested_quantity'   => 'required|integer|min:1',
            'quantity_unit'        => 'required|string|max:50',
            'beneficiary_count'    => 'required|integer|min:1',
            'purpose'              => 'required|string|max:500',
            'transport'            => 'required|in:self,need_help',
            'preferred_pickup_from'=> 'required|date',
            'preferred_pickup_to'  => 'required|date|after:preferred_pickup_from',
            'delivery_address'     => 'required|string|max:500',
            'priority'             => 'required|in:normal,urgent,emergency',
            'notes'                => 'nullable|string|max:1000',
        ]);

        $validated['status'] = 'pending';
        FoodRequest::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Your food request has been submitted successfully!',
        ], 201);
    }

    /** Get all food requests associated with a donor's donations */
    public function donorRequests(Request $request)
    {
        $request->validate([
            'donor_id' => 'required|integer|exists:donor,id'
        ]);

        $requests = FoodRequest::whereHas('donation', function($query) use ($request) {
            $query->where('donor_id', $request->donor_id);
        })->with('donation')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'requests' => $requests
        ]);
    }

    /** Get all food requests made by a specific NGO/Volunteer */
    public function ngoRequests(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $requests = FoodRequest::where('requester_email', $request->email)
            ->with('donation.donor')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'requests' => $requests
        ]);
    }

    /** Approve a food request */
    public function approve(string $id)
    {
        $foodReq = FoodRequest::findOrFail($id);
        if ($foodReq->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Request is not pending.'], 400);
        }

        $foodReq->status = 'approved';
        $foodReq->save();

        DonorResponse::create([
            'food_request_id' => $foodReq->id,
            'donation_id'     => $foodReq->donation_id,
            'status'          => 'approved',
            'message'         => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Request approved successfully.'
        ]);
    }

    /** Reject a food request */
    public function reject(string $id)
    {
        $foodReq = FoodRequest::findOrFail($id);
        if ($foodReq->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Request is not pending.'], 400);
        }

        $foodReq->status = 'rejected';
        $foodReq->save();

        DonorResponse::create([
            'food_request_id' => $foodReq->id,
            'donation_id'     => $foodReq->donation_id,
            'status'          => 'rejected',
            'message'         => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Request rejected successfully.'
        ]);
    }
}

