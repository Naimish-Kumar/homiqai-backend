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
        return response()->json([
            'success' => true,
            'message' => 'Notifications fetched successfully',
            'data' => [
                [
                    'id' => 1,
                    'title' => 'Welcome to Homiq AI',
                    'message' => 'Explore the future of interior design with our AI-powered studio.',
                    'type' => 'system',
                    'created_at' => now()->subDays(1)->toDateTimeString(),
                ],
                [
                    'id' => 2,
                    'title' => 'New Style Added!',
                    'message' => 'Check out the new "Luxury Midnight" design style in the studio.',
                    'type' => 'update',
                    'created_at' => now()->subHours(5)->toDateTimeString(),
                ],
                [
                    'id' => 3,
                    'title' => 'Pro Features Unlocked',
                    'message' => 'Your account now has access to high-resolution generation.',
                    'type' => 'subscription',
                    'created_at' => now()->subMinutes(30)->toDateTimeString(),
                ]
            ]
        ]);
    }
}
