<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NGOVolunteer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class NGOVolunteerController extends Controller
{
    /**
     * Authenticate an existing NGO / Volunteer against the database.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = NGOVolunteer::where('email', $request->email)->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'field'   => !$user ? 'email' : 'password',
                'message' => !$user
                    ? 'No account found with this email. Please register first.'
                    : 'Incorrect password. Please try again.',
            ], 401);
        }

        return response()->json([
            'success'       => true,
            'email'         => $user->email,
            'name'          => $user->first_name,
            'last'          => $user->last_name,
            'phone'         => $user->phone,
            'city'          => $user->city,
            'org'           => $user->organisation,
            'receiver_type' => $user->receiver_type,
            'role'          => 'ngo',
            'isNgo'         => true,
        ]);
    }

    /**
     * Store a newly registered NGO / Volunteer in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'email'         => 'required|email|unique:ngo_volunteer,email',
            'phone'         => 'required|string|max:20',
            'organisation'  => 'nullable|string|max:200',
            'receiver_type' => 'required|in:ngo,volunteer,shelter',
            'city'          => 'required|string|max:100',
            'password'      => 'required|string|min:8',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        NGOVolunteer::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Account created successfully.',
        ], 201);
    }

    public function index()   { /* reserved for future admin panel */ }
    public function create()  { return view('ngo-login'); }
    public function show(string $id)   { /* reserved */ }
    public function edit(string $id)   { /* reserved */ }
    public function update(Request $request, string $id) { /* reserved */ }
    public function destroy(string $id) { /* reserved */ }
}

