<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodRequest;
use Illuminate\Http\Request;

class FoodRequestController extends Controller
{
    public function index()
    {
        $requests = FoodRequest::with('donation')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.requests.index', compact('requests'));
    }

    public function show($id)
    {
        $request = FoodRequest::with(['donation', 'donation.donor'])->findOrFail($id);
        return view('admin.requests.show', compact('request'));
    }

    public function destroy($id)
    {
        $request = FoodRequest::findOrFail($id);
        $request->delete();
        return redirect()->route('admin.requests')->with('success', 'Food Request deleted successfully.');
    }
}
