<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Moodboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MoodboardController extends Controller
{
    public function index(Request $request)
    {
        $moodboards = $request->user()->moodboards()->with('style')->latest()->get();
        return response()->json([
            'success' => true,
            'data' => $moodboards
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'style_id' => 'nullable|exists:styles,id',
            'color_palette' => 'nullable|array',
            'items' => 'nullable|array',
            'project_id' => 'nullable|exists:projects,id,user_id,' . $request->user()->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $moodboard = $request->user()->moodboards()->create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Moodboard created successfully',
            'data' => $moodboard->load('style')
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $moodboard = $request->user()->moodboards()->with('style')->find($id);

        if (!$moodboard) {
            return response()->json([
                'success' => false,
                'message' => 'Moodboard not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $moodboard
        ]);
    }

    public function update(Request $request, $id)
    {
        $moodboard = $request->user()->moodboards()->find($id);

        if (!$moodboard) {
            return response()->json([
                'success' => false,
                'message' => 'Moodboard not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'style_id' => 'nullable|exists:styles,id',
            'color_palette' => 'nullable|array',
            'items' => 'nullable|array',
            'project_id' => 'nullable|exists:projects,id,user_id,' . $request->user()->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $moodboard->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Moodboard updated successfully',
            'data' => $moodboard->load('style')
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $moodboard = $request->user()->moodboards()->find($id);

        if (!$moodboard) {
            return response()->json([
                'success' => false,
                'message' => 'Moodboard not found'
            ], 404);
        }

        $moodboard->delete();

        return response()->json([
            'success' => true,
            'message' => 'Moodboard deleted successfully'
        ]);
    }

    public function share(Request $request, $id)
    {
        $moodboard = $request->user()->moodboards()->find($id);

        if (!$moodboard) {
            return response()->json([
                'success' => false,
                'message' => 'Moodboard not found'
            ], 404);
        }

        $signature = hash_hmac('sha256', $id, config('app.key'));
        $hash = base64_encode($id . ':' . $signature);

        $shareUrl = url('/shared/moodboard/' . urlencode($hash));

        return response()->json([
            'success' => true,
            'share_url' => $shareUrl,
        ]);
    }
}
