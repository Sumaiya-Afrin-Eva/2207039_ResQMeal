<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DonorController extends Controller
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
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:donor,email',
            'phone'      => 'required|string|max:20',
            'organisation' => 'nullable|string|max:255',
            'city'       => 'required|string|max:255',
            'donor_type' => 'required|in:individual,restaurant,event,other',
            'password'   => 'required|string|min:6'
        ]);

        $donor = \App\Models\Donor::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'organisation' => $validated['organisation'] ?? null,
            'city'       => $validated['city'],
            'donor_type' => $validated['donor_type'],
            'password'   => Hash::make($validated['password']),
            'is_verified'=> true // Set to true so donors can log in immediately
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Donor registered successfully!',
            'donor' => $donor
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $donor = \App\Models\Donor::where('email', $request->email)->first();

        if (!$donor) {
            return response()->json(['success' => false, 'message' => 'No account found with this email.']);
        }

        $isValid = false;
        
        if ($donor->password === $request->password) {
            // It's a match with an old plain-text password!
            $isValid = true;
            
            // Auto-upgrade their password to a secure hash for future logins
            $donor->password = Hash::make($request->password);
            $donor->save();
        } else {
            // Try checking against bcrypt, catch exception if it's not a valid bcrypt hash
            try {
                $isValid = Hash::check($request->password, $donor->password);
            } catch (\RuntimeException $e) {
                $isValid = false;
            }
        }

        if (!$isValid) {
            return response()->json(['success' => false, 'message' => 'Incorrect password.']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'donor' => $donor
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
