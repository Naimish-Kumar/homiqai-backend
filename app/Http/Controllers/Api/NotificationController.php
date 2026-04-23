<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get user notifications.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $notifications = \App\Models\Notification::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhereNull('user_id');
            })
            ->latest()
            ->get()
            ->map(function($n) {
                return [
                    'id' => $n->id,
                    'title' => $n->title,
                    'message' => $n->message,
                    'type' => $n->type,
                    'is_read' => $n->is_read,
                    'data' => $n->data,
                    'created_at' => $n->created_at->toDateTimeString(),
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Notifications fetched successfully',
            'data' => $notifications
        ]);
    }
}
