<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $query = $request->user()->roomDesigns()->with(['style', 'furnitureRecommendations'])->latest();

        // Filter favorites only
        if ($request->boolean('favorites_only')) {
            $query->where('is_favorite', true);
        }

        $designs = $query->get()->map(fn ($d) => $this->formatDesign($d));

        return response()->json($designs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'style_id' => 'required|exists:styles,id',
            'room_type' => 'required|string|max:50',
            'budget' => 'required|in:low,medium,high',
            'image' => 'required|image|max:10240', // 10MB max
        ]);

        $user = $request->user();

        if ($user->is_blocked) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is blocked from creating new designs.',
            ], 403);
        }

        $style = Style::find($request->style_id);

        // Check free designs limit for non-premium users
        if ($user->free_designs_left !== null && $user->free_designs_left <= 0) {
            // Check if user has active subscription
            $hasSubscription = $user->subscriptions()
                ->where('status', 'active')
                ->where('end_date', '>', now())
                ->exists();

            if (!$hasSubscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'No free designs remaining. Please upgrade to continue.',
                ], 403);
            }
        }

        // Store the original image (S3-ready: change disk in .env)
        $disk = config('filesystems.default', 'public');
        $path = $request->file('image')->store('designs/original', 'public');

        // Create the design record
        $design = RoomDesign::create([
            'user_id' => $user->id,
            'style_id' => $style->id,
            'room_type' => $request->room_type,
            'budget' => $request->budget,
            'original_image_path' => $path,
            'status' => 'processing',
        ]);

        // Decrement free designs for non-premium users
        if ($user->free_designs_left !== null && $user->free_designs_left > 0) {
            $user->decrement('free_designs_left');
        }

        // Trigger AI generation
        $this->aiService->generateDesign($design);

        return response()->json($this->formatDesign($design->fresh(['style', 'furnitureRecommendations'])), 201);
    }

    public function show(Request $request, RoomDesign $design)
    {
        abort_unless($design->user_id === $request->user()->id, 403);

        return response()->json($this->formatDesign($design->load(['style', 'furnitureRecommendations'])));
    }

    public function destroy(Request $request, RoomDesign $design)
    {
        abort_unless($design->user_id === $request->user()->id, 403);

        // Delete images from storage
        if ($design->original_image_path) {
            Storage::disk('public')->delete($design->original_image_path);
        }
        if ($design->generated_image_path) {
            Storage::disk('public')->delete($design->generated_image_path);
        }

        $design->delete();

        return response()->json(['success' => true, 'message' => 'Design deleted']);
    }

    public function toggleFavorite(Request $request, RoomDesign $design)
    {
        abort_unless($design->user_id === $request->user()->id, 403);

        $design->update(['is_favorite' => !$design->is_favorite]);

        return response()->json([
            'success' => true,
            'is_favorite' => $design->is_favorite,
        ]);
    }

    /**
     * Format a design with full public URLs instead of relative paths.
     * Uses signed/temporary URLs when S3 is configured (image privacy protection).
     */
    private function formatDesign(RoomDesign $design): array
    {
        $data = $design->toArray();
        $disk = Storage::disk('public');
        $useSignedUrls = config('filesystems.default') === 's3';

        if ($design->original_image_path) {
            $data['original_image_url'] = $useSignedUrls
                ? $disk->temporaryUrl($design->original_image_path, now()->addHours(2))
                : $disk->url($design->original_image_path);
        }

        if ($design->generated_image_path) {
            $data['generated_image_url'] = $useSignedUrls
                ? $disk->temporaryUrl($design->generated_image_path, now()->addHours(2))
                : $disk->url($design->generated_image_path);
        }

        return $data;
    }
}
