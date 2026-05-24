<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LayoutController extends Controller
{
    public function index(Request $request)
    {
        $layouts = $request->user()->layouts()->latest()->get();
        foreach ($layouts as $layout) {
            $this->checkAndResolveLayout($layout);
        }
        
        return response()->json([
            'success' => true,
            'data' => $layouts->fresh()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'floor_plan' => 'required|image|max:10240',
            'project_id' => 'nullable|exists:projects,id,user_id,' . $request->user()->id,
        ]);

        $path = $request->file('floor_plan')->store('floor_plans', 'public');
        $url = Storage::disk('public')->url($path);

        $layout = Layout::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'floor_plan_url' => $url,
            'status' => 'processing',
            'project_id' => $request->project_id,
        ]);

        return response()->json([
            'success' => true,
            'data' => $layout
        ]);
    }

    public function show($id)
    {
        $layout = Layout::findOrFail($id);
        
        if ($layout->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $this->checkAndResolveLayout($layout);

        return response()->json([
            'success' => true,
            'data' => $layout->fresh()
        ]);
    }

    public function update(Request $request, $id)
    {
        $layout = Layout::findOrFail($id);

        if ($layout->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'items' => 'nullable|array',
            'total_price' => 'nullable|numeric|min:0',
            'project_id' => 'nullable|exists:projects,id,user_id,' . auth()->id(),
            'wall_color' => 'nullable|string|max:45',
            'floor_color' => 'nullable|string|max:45',
            'floor_material' => 'nullable|string|max:255',
            'ceiling_color' => 'nullable|string|max:45',
            'saved_palettes' => 'nullable|array',
        ]);

        $layout->update($request->only([
            'name', 
            'items', 
            'total_price', 
            'project_id',
            'wall_color',
            'floor_color',
            'floor_material',
            'ceiling_color',
            'saved_palettes'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Layout updated successfully',
            'data' => $layout->fresh()
        ]);
    }

    public function destroy($id)
    {
        $layout = Layout::findOrFail($id);
        
        if ($layout->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $layout->delete();

        return response()->json([
            'success' => true,
            'message' => 'Layout deleted successfully'
        ]);
    }

    private function checkAndResolveLayout(Layout $layout)
    {
        if ($layout->status === 'processing' && $layout->created_at->diffInSeconds(now()) >= 10) {
            $layout->update([
                'result_3d_url' => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?q=80&w=2070&auto=format&fit=crop',
                'status' => 'completed'
            ]);
        }
        return $layout;
    }
}
