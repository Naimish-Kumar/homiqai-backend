<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RoomDesign;
use App\Models\Style;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DesignController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index(Request $request)
    {
        $designs = $request->user()->roomDesigns()->with('style')->latest()->get();
        return response()->json($designs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'style_id' => 'required|exists:styles,id',
            'budget' => 'required|in:low,medium,high',
            'image' => 'required|image|max:10240', // 10MB max
        ]);

        $style = Style::find($request->style_id);

        // Store the original image
        $path = $request->file('image')->store('designs/original', 'public');

        // Create the design record
        $design = RoomDesign::create([
            'user_id' => $request->user()->id,
            'style_id' => $style->id,
            'budget' => $request->budget,
            'original_image_path' => $path,
            'status' => 'processing',
        ]);

        // Trigger AI generation (In a real app, this should be a background job)
        $this->aiService->generateDesign($design);

        return response()->json($design->load('style'), 201);
    }

    public function show(RoomDesign $design)
    {
        return response()->json($design->load(['style', 'furnitureRecommendations']));
    }
}
