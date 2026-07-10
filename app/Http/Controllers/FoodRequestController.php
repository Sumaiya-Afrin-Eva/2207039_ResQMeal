<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $foodRequest = FoodRequest::create($validated);

        if (!empty($validated['donation_id'])) {
            $donation = Donation::find($validated['donation_id']);
            if ($donation && $donation->donor_id) {
                $donor = \App\Models\Donor::find($donation->donor_id);
                if ($donor && $donor->email) {
                    $donorName = trim($donor->first_name . ' ' . $donor->last_name);
                    $subject = 'New Food Request Received!';
                    $content = "<p>Hello {$donorName},</p><p>You have received a new food request for your donation <b>{$donation->food_name}</b> from <b>{$foodRequest->requester_name}</b>.</p><p>Please log in to your dashboard to review it.</p>";
                    $this->sendEmailNotification($donor->email, $donorName, $subject, $content);
                }
            }
        }

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

        if ($foodReq->requester_email) {
            $donation = Donation::find($foodReq->donation_id);
            $foodName = $donation ? $donation->food_name : 'Food Donation';
            $subject = 'Food Request Approved!';
            $content = "<p>Hello {$foodReq->requester_name},</p><p>Good news! Your request for <b>{$foodName}</b> has been approved by the donor.</p><p>Please proceed to coordinate the pickup.</p>";
            $this->sendEmailNotification($foodReq->requester_email, $foodReq->requester_name, $subject, $content);
        }

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

        if ($foodReq->requester_email) {
            $donation = Donation::find($foodReq->donation_id);
            $foodName = $donation ? $donation->food_name : 'Food Donation';
            $subject = 'Food Request Update';
            $content = "<p>Hello {$foodReq->requester_name},</p><p>We're sorry, but your request for <b>{$foodName}</b> could not be approved at this time.</p><p>Please check the live feed for other available donations.</p>";
            $this->sendEmailNotification($foodReq->requester_email, $foodReq->requester_name, $subject, $content);
        }

        return response()->json([
            'success' => true,
            'message' => 'Request rejected successfully.'
        ]);
    }

    private function sendEmailNotification($toEmail, $toName, $subject, $content)
    {
        try {
            $apiKey = env('BREVO_API_KEY');
            if (!$apiKey) return;

            $client = new \GuzzleHttp\Client();
            $client->post('https://api.brevo.com/v3/smtp/email', [
                'headers' => [
                    'api-key' => $apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'sender' => [
                        'name' => 'ResQMeal Notifications',
                        'email' => env('BREVO_SENDER_EMAIL', 'noreply@resqmeal.org')
                    ],
                    'to' => [
                        [
                            'email' => $toEmail,
                            'name' => $toName
                        ]
                    ],
                    'subject' => $subject,
                    'htmlContent' => $content
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
        }
    }
}

