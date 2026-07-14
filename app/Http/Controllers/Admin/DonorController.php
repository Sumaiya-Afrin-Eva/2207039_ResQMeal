<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DonorController extends Controller
{
    public function index()
    {
        $donors = Donor::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.donors.index', compact('donors'));
    }

    public function create()
    {
        return view('admin.donors.create');
    }

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

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_verified'] = true;

        Donor::create($validated);

        return redirect()->route('admin.donors')->with('success', 'Donor created successfully.');
    }

    public function edit($id)
    {
        $donor = Donor::findOrFail($id);
        return view('admin.donors.edit', compact('donor'));
    }

    public function update(Request $request, $id)
    {
        $donor = Donor::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:donor,email,' . $donor->id,
            'phone'      => 'required|string|max:20',
            'organisation' => 'nullable|string|max:255',
            'city'       => 'required|string|max:255',
            'donor_type' => 'required|in:individual,restaurant,event,other',
            'password'   => 'nullable|string|min:6'
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $donor->update($validated);

        return redirect()->route('admin.donors')->with('success', 'Donor updated successfully.');
    }

    public function destroy($id)
    {
        $donor = Donor::findOrFail($id);
        $donor->delete();

        return redirect()->route('admin.donors')->with('success', 'Donor deleted successfully.');
    }
}
