<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FurnitureProduct;
use Illuminate\Http\Request;

class FurnitureController extends Controller
{
    public function index(Request $request)
    {
        $query = FurnitureProduct::query()->where('is_active', true);

        if ($request->has('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        if ($request->has('style_id')) {
            $query->whereHas('styles', function($q) use ($request) {
                $q->where('styles.id', $request->style_id);
            });
        }

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('brand', 'like', '%' . $searchTerm . '%')
                  ->orWhere('category', 'like', '%' . $searchTerm . '%');
            });
        }

        $products = $query->with('styles')->latest()->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function categories()
    {
        $categories = FurnitureProduct::where('is_active', true)
            ->distinct()
            ->pluck('category')
            ->toArray();

        return response()->json([
            'success' => true,
            'data' => array_merge(['All'], $categories)
        ]);
    }

    public function show($id)
    {
        $product = FurnitureProduct::with('styles')->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }
}
