<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = $request->user()->projects()
            ->withCount(['roomDesigns', 'moodboards', 'layouts'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $projects
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'budget_limit' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        // Enforce project limit for free tier
        if (!$user->is_premium) {
            $activeCount = $user->projects()->where('status', 'active')->count();
            if ($activeCount >= 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Free tier is limited to 2 active projects. Please upgrade to Pro for unlimited projects.'
                ], 403);
            }
        }

        $project = $user->projects()->create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'active',
            'budget_limit' => $request->budget_limit ?? 3000.00,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Project created successfully',
            'data' => $project
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $project = $request->user()->projects()
            ->with(['roomDesigns.style', 'moodboards.style', 'layouts'])
            ->find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found'
            ], 404);
        }

        $projectData = $project->toArray();
        $disk = Storage::disk('public');
        $useSignedUrls = config('filesystems.default') === 's3';

        // Format Room Designs original & generated paths to public URLs
        if (isset($projectData['room_designs'])) {
            foreach ($projectData['room_designs'] as &$design) {
                if (isset($design['original_image_path']) && $design['original_image_path']) {
                    $design['original_image_url'] = $useSignedUrls
                        ? $disk->temporaryUrl($design['original_image_path'], now()->addHours(2))
                        : $disk->url($design['original_image_path']);
                }
                if (isset($design['generated_image_path']) && $design['generated_image_path']) {
                    $design['generated_image_url'] = $useSignedUrls
                        ? $disk->temporaryUrl($design['generated_image_path'], now()->addHours(2))
                        : $disk->url($design['generated_image_path']);
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => $projectData
        ]);
    }

    public function update(Request $request, $id)
    {
        $project = $request->user()->projects()->find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|string|in:active,archived',
            'budget_limit' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $project->update($request->only(['name', 'description', 'status', 'budget_limit']));

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully',
            'data' => $project
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $project = $request->user()->projects()->find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found'
            ], 404);
        }

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully'
        ]);
    }
}
