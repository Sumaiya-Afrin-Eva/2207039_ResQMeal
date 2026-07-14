<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NGOVolunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NGOController extends Controller
{
    public function index()
    {
        $ngos = NGOVolunteer::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.ngos.index', compact('ngos'));
    }

    public function create()
    {
        return view('admin.ngos.create');
    }

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

        return redirect()->route('admin.ngos')->with('success', 'NGO/Volunteer created successfully.');
    }

    public function edit($id)
    {
        $ngo = NGOVolunteer::findOrFail($id);
        return view('admin.ngos.edit', compact('ngo'));
    }

    public function update(Request $request, $id)
    {
        $ngo = NGOVolunteer::findOrFail($id);

        $validated = $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'email'         => 'required|email|unique:ngo_volunteer,email,' . $ngo->id,
            'phone'         => 'required|string|max:20',
            'organisation'  => 'nullable|string|max:200',
            'receiver_type' => 'required|in:ngo,volunteer,shelter',
            'city'          => 'required|string|max:100',
            'password'      => 'nullable|string|min:8',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $ngo->update($validated);

        return redirect()->route('admin.ngos')->with('success', 'NGO/Volunteer updated successfully.');
    }

    public function destroy($id)
    {
        $ngo = NGOVolunteer::findOrFail($id);
        $ngo->delete();

        return redirect()->route('admin.ngos')->with('success', 'NGO/Volunteer deleted successfully.');
    }
}
