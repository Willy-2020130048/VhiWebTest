<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query('size', 10);
        return Vendor::where('status', 'approved')->paginate($size);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'required|string|max:20',
        ]);

        $id = auth()->id();
        $exist = Vendor::where('user_id', $id)->first();

        if ($exist) {
            return response()->json([
                'message' => 'Already registered with vendor id: ' . $exist->id
            ], 403);
        }

        $vendor = Vendor::create([
            'id' => Str::uuid(),
            'user_id' => $id,
            ...$validated,
        ]);

        return response()->json($vendor, 201);
    }

    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);
        return response()->json($vendor);
    }

    public function update(Request $request, $id)
    {
        $vendor = Vendor::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'status' => 'nullable|string|in:pending,approved,rejected',
        ]);

        $vendor->update($validated);

        return response()->json($vendor);
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $vendor = Vendor::findOrFail($id);
        $vendor->status = $request->status;
        $vendor->save();

        return response()->json([
            'message' => 'Status updated',
            'vendor' => $vendor,
        ]);
    }
    
    public function destroy($id)
    {
        $vendor = Vendor::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        $vendor->delete();

        return response()->json(['message' => 'Vendor deleted']);
    }
}
