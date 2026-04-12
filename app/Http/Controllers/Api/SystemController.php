<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    /**
     * Get initial application settings.
     * Required for Flutter app handshake on startup.
     */
    public function index()
    {
        return response()->json([
            'error' => false,
            'message' => 'Settings fetched successfully',
            'data' => [
                'light_tertiary' => '#F3F4F6',
                'placeholder_logo' => asset('images/logo.png'),
                'light_secondary' => '#1F2937',
                'light_primary' => '#3A86FF', // Neon Blue
                'dark_tertiary' => '#111827',
                'dark_secondary' => '#1F2937',
                'dark_primary' => '#3A86FF', // Neon Blue
                'app_home_screen' => asset('images/logo.png'),
                'is_active' => true,
            ]
        ]);
    }
}
