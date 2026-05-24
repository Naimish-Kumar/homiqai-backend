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

        $budget = $request->input('budget');
        if (!$budget && $request->user()) {
            $lastDesign = $request->user()->roomDesigns()->latest()->first();
            $budget = $lastDesign ? $lastDesign->budget : 'medium';
        }
        if (!$budget) {
            $budget = 'medium';
        }
        $priceColumn = match ($budget) {
            'low' => 'low_price',
            'high' => 'high_price',
            default => 'medium_price',
        };

        if ($request->has('min_price')) {
            $query->where($priceColumn, '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where($priceColumn, '<=', $request->max_price);
        }

        if ($request->has('material')) {
            $query->where('material', 'like', '%' . $request->material . '%');
        }

        if ($request->has('dimensions')) {
            $query->where('dimensions', 'like', '%' . $request->dimensions . '%');
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

    public function visualSearch(Request $request, \App\Services\AIService $aiService)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // 5MB max
        ]);

        try {
            $path = $request->file('image')->store('temp/visual-search', 'public');
            
            // Analyze image using AI
            $analysis = $aiService->analyzeFurnitureImage($path);
            
            // Clean up temp image
            // Storage::disk('public')->delete($path);

            $query = FurnitureProduct::query()->where('is_active', true);

            if (isset($analysis['category'])) {
                $query->where('category', 'like', '%' . $analysis['category'] . '%');
            }

            if (isset($analysis['keywords'])) {
                $keywords = is_array($analysis['keywords']) ? $analysis['keywords'] : explode(' ', $analysis['keywords']);
                $query->where(function($q) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $q->orWhere('name', 'like', '%' . $keyword . '%')
                          ->orWhere('description', 'like', '%' . $keyword . '%');
                    }
                });
            }

            $products = $query->with('styles')->latest()->take(10)->get();

            return response()->json([
                'success' => true,
                'analysis' => $analysis,
                'data' => $products
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Visual search failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
