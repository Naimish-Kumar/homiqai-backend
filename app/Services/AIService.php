<?php

namespace App\Services;

use App\Models\FurnitureRecommendation;
use App\Models\RoomDesign;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AIService
{
    /**
     * Generate a new room design based on an original image and a style.
     * Uses Stability AI (primary) or OpenAI DALL-E (fallback).
     */
    public function generateDesign(RoomDesign $roomDesign): RoomDesign
    {
        $provider = config('services.ai.provider', 'stability');

        try {
            $roomDesign->update(['status' => 'processing']);

            if ($provider === 'stability') {
                $generatedPath = $this->generateWithStabilityAI($roomDesign);
            } else {
                $generatedPath = $this->generateWithOpenAI($roomDesign);
            }

            $roomDesign->update([
                'generated_image_path' => $generatedPath,
                'status' => 'completed',
                'metadata' => [
                    'ai_provider' => $provider,
                    'prompt_used' => $this->buildPrompt($roomDesign),
                    'processed_at' => now()->toDateTimeString(),
                ],
            ]);

            // Generate furniture recommendations
            $this->generateFurnitureRecommendations($roomDesign);

        } catch (\Exception $e) {
            Log::error('AI Generation Failed', [
                'design_id' => $roomDesign->id,
                'provider' => $provider,
                'error' => $e->getMessage(),
            ]);

            // Try fallback provider
            if ($provider === 'stability' && config('services.openai.key')) {
                try {
                    $generatedPath = $this->generateWithOpenAI($roomDesign);
                    $roomDesign->update([
                        'generated_image_path' => $generatedPath,
                        'status' => 'completed',
                        'metadata' => [
                            'ai_provider' => 'openai_fallback',
                            'prompt_used' => $this->buildPrompt($roomDesign),
                            'processed_at' => now()->toDateTimeString(),
                            'primary_error' => $e->getMessage(),
                        ],
                    ]);
                    return $roomDesign;
                } catch (\Exception $fallbackError) {
                    Log::error('AI Fallback Also Failed', [
                        'error' => $fallbackError->getMessage(),
                    ]);
                }
            }

            $roomDesign->update([
                'status' => 'failed',
                'metadata' => [
                    'error' => $e->getMessage(),
                    'failed_at' => now()->toDateTimeString(),
                ],
            ]);
        }

        return $roomDesign;
    }

    /**
     * Generate design using Stability AI's image-to-image API.
     */
    private function generateWithStabilityAI(RoomDesign $roomDesign): string
    {
        $apiKey = config('services.stability_ai.key');
        if (empty($apiKey)) {
            throw new \RuntimeException('Stability AI API key is not configured.');
        }

        $originalPath = Storage::disk('public')->path($roomDesign->original_image_path);
        $prompt = $this->buildPrompt($roomDesign);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Accept' => 'image/*',
        ])
        ->timeout(120)
        ->attach('image', file_get_contents($originalPath), 'room.jpg')
        ->post('https://api.stability.ai/v2beta/stable-image/generate/sd3', [
            ['name' => 'prompt', 'contents' => $prompt],
            ['name' => 'mode', 'contents' => 'image-to-image'],
            ['name' => 'model', 'contents' => config('services.stability_ai.model', 'sd3-large')],
            ['name' => 'strength', 'contents' => '0.65'],
            ['name' => 'output_format', 'contents' => 'jpeg'],
        ]);

        if ($response->failed()) {
            throw new \RuntimeException(
                'Stability AI API error: ' . $response->status() . ' — ' . $response->body()
            );
        }

        // Save the generated image
        $filename = 'designs/generated/' . Str::uuid() . '.jpg';
        Storage::disk('public')->put($filename, $response->body());

        return $filename;
    }

    /**
     * Generate design using OpenAI DALL-E API (fallback).
     * Note: DALL-E doesn't support image-to-image natively,
     * so we use the edit endpoint or generate from prompt only.
     */
    private function generateWithOpenAI(RoomDesign $roomDesign): string
    {
        $apiKey = config('services.openai.key');
        if (empty($apiKey)) {
            throw new \RuntimeException('OpenAI API key is not configured.');
        }

        $prompt = $this->buildPrompt($roomDesign);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])
        ->timeout(120)
        ->post('https://api.openai.com/v1/images/generations', [
            'model' => config('services.openai.model', 'dall-e-3'),
            'prompt' => $prompt,
            'n' => 1,
            'size' => '1024x1024',
            'quality' => 'hd',
        ]);

        if ($response->failed()) {
            throw new \RuntimeException(
                'OpenAI API error: ' . $response->status() . ' — ' . $response->body()
            );
        }

        $imageUrl = $response->json('data.0.url');
        if (!$imageUrl) {
            throw new \RuntimeException('OpenAI returned no image URL.');
        }

        // Download and save the generated image
        $imageData = Http::timeout(60)->get($imageUrl)->body();
        $filename = 'designs/generated/' . Str::uuid() . '.jpg';
        Storage::disk('public')->put($filename, $imageData);

        return $filename;
    }

    /**
     * Build the AI prompt from the room design's style and budget.
     */
    private function buildPrompt(RoomDesign $roomDesign): string
    {
        $style = $roomDesign->style;
        $budget = $roomDesign->budget;

        $budgetDescriptions = [
            'low' => 'affordable, budget-friendly materials like laminate, MDF, and cotton textiles',
            'medium' => 'mid-range materials like engineered wood, quality fabrics, and ceramic tiles',
            'high' => 'premium materials like solid hardwood, marble, brass fixtures, and designer furniture',
        ];

        $budgetDesc = $budgetDescriptions[$budget] ?? $budgetDescriptions['medium'];

        $prompt = "Redesign this interior room in a {$style->name} style. ";
        
        if ($style->prompt_prefix) {
            $prompt .= $style->prompt_prefix . ' ';
        }

        $prompt .= "Use {$budgetDesc}. ";
        $prompt .= 'Maintain the same room layout and dimensions. ';
        $prompt .= 'Create a photorealistic, high-quality interior design visualization. ';
        $prompt .= 'Professional interior photography style, well-lit, detailed textures.';

        return $prompt;
    }

    /**
     * Generate furniture recommendations based on style and budget.
     */
    private function generateFurnitureRecommendations(RoomDesign $roomDesign): void
    {
        $style = $roomDesign->style;
        $budget = $roomDesign->budget;

        // Amazon India Affiliate Tag — replace with your own tag from
        // https://affiliate-program.amazon.in/
        $affiliateTag = config('services.affiliate.amazon_tag', 'homiqai-21');

        // Static furniture suggestions based on style and budget
        $furnitureByStyle = [
            'Modern' => [
                ['name' => 'Modular Sofa Set', 'category' => 'furniture', 'price_range' => ['low' => 15000, 'medium' => 35000, 'high' => 85000]],
                ['name' => 'Glass Coffee Table', 'category' => 'furniture', 'price_range' => ['low' => 3000, 'medium' => 8000, 'high' => 25000]],
                ['name' => 'LED Floor Lamp', 'category' => 'lighting', 'price_range' => ['low' => 1500, 'medium' => 5000, 'high' => 15000]],
                ['name' => 'Wall-mounted TV Unit', 'category' => 'furniture', 'price_range' => ['low' => 5000, 'medium' => 15000, 'high' => 45000]],
            ],
            'Minimal' => [
                ['name' => 'Platform Bed Frame', 'category' => 'furniture', 'price_range' => ['low' => 8000, 'medium' => 20000, 'high' => 55000]],
                ['name' => 'Floating Shelf Set', 'category' => 'furniture', 'price_range' => ['low' => 1200, 'medium' => 4000, 'high' => 12000]],
                ['name' => 'Simple Desk Chair', 'category' => 'furniture', 'price_range' => ['low' => 3000, 'medium' => 10000, 'high' => 30000]],
                ['name' => 'Linen Curtains', 'category' => 'home', 'price_range' => ['low' => 800, 'medium' => 2500, 'high' => 8000]],
            ],
            'Luxury' => [
                ['name' => 'Chesterfield Sofa', 'category' => 'furniture', 'price_range' => ['low' => 25000, 'medium' => 60000, 'high' => 150000]],
                ['name' => 'Crystal Chandelier', 'category' => 'lighting', 'price_range' => ['low' => 5000, 'medium' => 20000, 'high' => 75000]],
                ['name' => 'Marble Side Table', 'category' => 'furniture', 'price_range' => ['low' => 4000, 'medium' => 15000, 'high' => 45000]],
                ['name' => 'Velvet Accent Chair', 'category' => 'furniture', 'price_range' => ['low' => 8000, 'medium' => 25000, 'high' => 65000]],
            ],
            'Traditional Indian' => [
                ['name' => 'Sheesham Wood Sofa', 'category' => 'furniture', 'price_range' => ['low' => 12000, 'medium' => 30000, 'high' => 80000]],
                ['name' => 'Brass Diya Set', 'category' => 'home', 'price_range' => ['low' => 500, 'medium' => 2000, 'high' => 8000]],
                ['name' => 'Jaipur Block Print Cushions', 'category' => 'home', 'price_range' => ['low' => 300, 'medium' => 1200, 'high' => 4000]],
                ['name' => 'Carved Wooden Divider', 'category' => 'furniture', 'price_range' => ['low' => 5000, 'medium' => 15000, 'high' => 45000]],
            ],
            'Scandinavian' => [
                ['name' => 'Oak Dining Table', 'category' => 'furniture', 'price_range' => ['low' => 10000, 'medium' => 28000, 'high' => 70000]],
                ['name' => 'Wool Area Rug', 'category' => 'home', 'price_range' => ['low' => 2000, 'medium' => 8000, 'high' => 25000]],
                ['name' => 'Pendant Light', 'category' => 'lighting', 'price_range' => ['low' => 1500, 'medium' => 5000, 'high' => 18000]],
                ['name' => 'Storage Bench', 'category' => 'furniture', 'price_range' => ['low' => 3000, 'medium' => 10000, 'high' => 30000]],
            ],
        ];

        $styleName = $style->name ?? 'Modern';
        $furniture = $furnitureByStyle[$styleName] ?? $furnitureByStyle['Modern'];

        foreach ($furniture as $item) {
            $price = $item['price_range'][$budget] ?? $item['price_range']['medium'];
            $category = $item['category'] ?? 'furniture';

            // Build a proper Amazon India affiliate URL with tracking tag
            $searchQuery = urlencode($item['name'] . ' for home');
            $affiliateUrl = "https://www.amazon.in/s?k={$searchQuery}&i={$category}&tag={$affiliateTag}&linkCode=ll2&language=en_IN";

            FurnitureRecommendation::create([
                'room_design_id' => $roomDesign->id,
                'name' => $item['name'],
                'price' => $price,
                'purchase_link' => $affiliateUrl,
                'image_url' => null,
            ]);
        }
    }
}

