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

        $openAiKey = config('services.openai.key') ?: env('OPENAI_API_KEY');
        $geminiKey = config('services.gemini.key') ?: env('GEMINI_API_KEY');

        // 1. Try OpenAI if key is present
        if ($openAiKey) {
            try {
                $httpResponse = \Illuminate\Support\Facades\Http::withHeaders([
                    'Authorization' => 'Bearer ' . $openAiKey,
                ])
                ->timeout(30)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'system', 
                            'content' => 'You are Homiq AI, a sophisticated, friendly virtual interior designer assistant. You specialize in home design, Indian homes, space planning, lighting, budgets, and furniture styling. Give professional, inspiring, and direct advice. Format your output nicely using clear lists, bullet points, or short paragraphs with emojis.'
                        ],
                        ['role' => 'user', 'content' => $request->message]
                    ],
                    'temperature' => 0.7,
                ]);

                if ($httpResponse->successful()) {
                    $reply = $httpResponse->json('choices.0.message.content');
                    return response()->json([
                        'success' => true,
                        'reply' => $reply,
                        'role' => 'assistant'
                    ]);
                }
            } catch (\Exception $e) {
                // Fallback
            }
        }

        // 2. Try Gemini if key is present
        if ($geminiKey) {
            try {
                $httpResponse = \Illuminate\Support\Facades\Http::timeout(30)
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$geminiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => "System Instruction: You are Homiq AI, a sophisticated, friendly virtual interior designer assistant. You specialize in home design, Indian homes, space planning, lighting, budgets, and furniture styling. Give professional, inspiring, and direct advice. Format your output nicely using clear lists, bullet points, or short paragraphs with emojis.\n\nUser: " . $request->message]
                            ]
                        ]
                    ]
                ]);

                if ($httpResponse->successful()) {
                    $reply = $httpResponse->json('candidates.0.content.parts.0.text');
                    return response()->json([
                        'success' => true,
                        'reply' => $reply,
                        'role' => 'assistant'
                    ]);
                }
            } catch (\Exception $e) {
                // Fallback
            }
        }

        // 3. Static/Rule-based Fallback
        $message = strtolower($request->message);
        $response = "I'm here to help you design your dream space! How can I assist you with your home interior today?";

        if (str_contains($message, 'hello') || str_contains($message, 'hi')) {
            $response = "Hello! I am Homiq AI, your personal interior design assistant. Are you looking to redesign a specific room today?";
        } elseif (str_contains($message, 'minimalist')) {
            $response = "### Minimalist Styling Principles 🕊️\n\nMinimalism is all about 'less is more'. I recommend using a neutral color palette (whites, beiges, light grays) and focusing on functional, high-quality furniture with clean lines.";
        } elseif (str_contains($message, 'luxury') || str_contains($message, 'expensive')) {
            $response = "### Luxury Styling Secrets ✨\n\nFor a luxury feel, focus on rich textures like velvet and marble. Metallic accents in gold or champagne can elevate the space significantly. Deep tones like midnight blue or forest green work beautifully.";
        } elseif (str_contains($message, 'color') || str_contains($message, 'paint')) {
            $response = "### AI Color Vibe Guide 🎨\n\nChoosing the right color depends on the light in your room. For smaller spaces, lighter colors make it feel airy. For cozy dens, deep moody colors can add character.";
        } elseif (str_contains($message, 'budget')) {
            $response = "### Smart Budget Styling Tips 💰\n\nYou don't need a huge budget to make a space look great! Start with lighting—warm, layered lighting (lamps, scones) can change the entire mood of a room instantly.";
        }

        return response()->json([
            'success' => true,
            'reply' => $response,
            'role' => 'assistant'
        ]);
    }
}
