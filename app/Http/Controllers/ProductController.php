<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function indexByVendor(Request $request)
    {
        $size = $request->query('size', 10);
        $vendor = Vendor::where('user_id', auth()->id())->firstOrFail();
        return Product::where('vendor_id', $vendor->id)->paginate($size);
    }

    public function indexForUser(Request $request)
    {
        $size = $request->query('size', 10);
        return Product::where('active', true)
        ->whereHas('vendor', function ($query) {
            $query->where('status', 'approved');
        })
        ->paginate($size);
    }

    public function store(Request $request)
    {
        $vendor = Vendor::where('user_id', auth()->id())->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
            'active' => 'nullable|boolean',
        ]);

        $product = Product::create([
            'id' => Str::uuid(),
            'vendor_id' => $vendor->id,
            ...$validated,
        ]);

        return response()->json($product, 201);
    }

    public function show($id)
    {
        $vendor = Vendor::where('user_id', auth()->id())->firstOrFail();

        $product = Product::where('id', $id)
                          ->where('vendor_id', $vendor->id)
                          ->firstOrFail();

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $vendor = Vendor::where('user_id', auth()->id())->firstOrFail();

        $product = Product::where('id', $id)
                          ->where('vendor_id', $vendor->id)
                          ->firstOrFail();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'active' => 'nullable|boolean',
        ]);

        $product->update($validated);

        return response()->json($product);
    }

    public function destroy($id)
    {
        $vendor = Vendor::where('user_id', auth()->id())->firstOrFail();

        $product = Product::where('id', $id)
                          ->where('vendor_id', $vendor->id)
                          ->firstOrFail();

        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'active' => 'required|boolean',
        ]);

        $product = Product::findOrFail($id);
        $product->active = $request->active;
        $product->save();

        return response()->json([
            'message' => 'Status updated',
            'product' => $product,
        ]);
    }
}
