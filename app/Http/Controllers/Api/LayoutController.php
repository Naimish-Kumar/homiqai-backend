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
        
        return response()->json([
            'success' => true,
            'data' => $layouts
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'floor_plan' => 'required|image|max:10240',
        ]);

        $path = $request->file('floor_plan')->store('floor_plans', 'public');
        $url = Storage::disk('public')->url($path);

        $layout = Layout::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'floor_plan_url' => $url,
            'status' => 'processing',
        ]);

        // Mock AI Processing - in real app, dispatch job
        // For demo, we'll just set a placeholder result
        $layout->update([
            'result_3d_url' => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?q=80&w=2070&auto=format&fit=crop',
            'status' => 'completed'
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

        return response()->json([
            'success' => true,
            'data' => $layout
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
}
