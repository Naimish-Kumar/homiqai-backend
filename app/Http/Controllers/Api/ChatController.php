<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Get AI Response for interior design questions.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = strtolower($request->message);
        $response = "I'm here to help you design your dream space! How can I assist you with your home interior today?";

        if (str_contains($message, 'hello') || str_contains($message, 'hi')) {
            $response = "Hello! I am Homiq AI, your personal interior design assistant. Are you looking to redesign a specific room today?";
        } elseif (str_contains($message, 'minimalist')) {
            $response = "Minimalism is all about 'less is more'. I recommend using a neutral color palette (whites, beiges, light grays) and focusing on functional, high-quality furniture with clean lines.";
        } elseif (str_contains($message, 'luxury') || str_contains($message, 'expensive')) {
            $response = "For a luxury feel, focus on rich textures like velvet and marble. Metallic accents in gold or champagne can elevate the space significantly. Deep tones like midnight blue or forest green work beautifully.";
        } elseif (str_contains($message, 'color') || str_contains($message, 'paint')) {
            $response = "Choosing the right color depends on the light in your room. For smaller spaces, lighter colors make it feel airy. For cozy dens, deep moody colors can add character.";
        } elseif (str_contains($message, 'budget')) {
            $response = "You don't need a huge budget to make a space look great! Start with lighting—warm, layered lighting (lamps, scones) can change the entire mood of a room instantly.";
        }

        return response()->json([
            'success' => true,
            'reply' => $response,
            'role' => 'assistant'
        ]);
    }
}
