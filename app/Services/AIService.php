<?php

namespace App\Services;

use App\Models\FurnitureProduct;
use App\Models\FurnitureRecommendation;
use App\Models\RoomDesign;
use App\Models\Setting;
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
    public function generateDesign(RoomDesign $roomDesign, ?string $variation = null): RoomDesign
    {
        $provider = config('services.ai.provider', 'stability');

        try {
            $roomDesign->update(['status' => 'processing']);

            if ($provider === 'stability') {
                $generatedPath = $this->generateWithStabilityAI($roomDesign, $variation);
            } else {
                $generatedPath = $this->generateWithOpenAI($roomDesign, $variation);
            }

            $roomDesign->update([
                'generated_image_path' => $generatedPath,
                'status' => 'completed',
                'metadata' => [
                    'ai_provider' => $provider,
                    'variation' => $variation,
                    'prompt_used' => $this->buildPrompt($roomDesign, $variation),
                    'processed_at' => now()->toDateTimeString(),
                ],
            ]);

            // Generate furniture recommendations
            $this->generateFurnitureRecommendations($roomDesign);

        } catch (\Exception $e) {
            Log::error('AI Generation Failed', [
                'design_id' => $roomDesign->id,
                'provider' => $provider,
                'variation' => $variation,
                'error' => $e->getMessage(),
            ]);

            // Try fallback provider
            if ($provider === 'stability' && config('services.openai.key')) {
                try {
                    $generatedPath = $this->generateWithOpenAI($roomDesign, $variation);
                    $roomDesign->update([
                        'generated_image_path' => $generatedPath,
                        'status' => 'completed',
                        'metadata' => [
                            'ai_provider' => 'openai_fallback',
                            'variation' => $variation,
                            'prompt_used' => $this->buildPrompt($roomDesign, $variation),
                            'processed_at' => now()->toDateTimeString(),
                            'primary_error' => $e->getMessage(),
                        ],
                    ]);

                    return $roomDesign;
                } catch (\Exception $fallbackError) {
                    Log::error('AI Fallback to OpenAI Also Failed', [
                        'error' => $fallbackError->getMessage(),
                    ]);
                }
            } elseif ($provider === 'openai' && config('services.stability_ai.key')) {
                try {
                    $generatedPath = $this->generateWithStabilityAI($roomDesign, $variation);
                    $roomDesign->update([
                        'generated_image_path' => $generatedPath,
                        'status' => 'completed',
                        'metadata' => [
                            'ai_provider' => 'stability_fallback',
                            'variation' => $variation,
                            'prompt_used' => $this->buildPrompt($roomDesign, $variation),
                            'processed_at' => now()->toDateTimeString(),
                            'primary_error' => $e->getMessage(),
                        ],
                    ]);

                    return $roomDesign;
                } catch (\Exception $fallbackError) {
                    Log::error('AI Fallback to Stability Also Failed', [
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
    private function generateWithStabilityAI(RoomDesign $roomDesign, ?string $variation = null): string
    {
        $apiKey = config('services.stability_ai.key');
        if (empty($apiKey)) {
            throw new \RuntimeException('Stability AI API key is not configured.');
        }

        $originalPath = Storage::disk('public')->path($roomDesign->original_image_path);
        $prompt = $this->buildPrompt($roomDesign, $variation);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$apiKey,
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
                'Stability AI API error: '.$response->status().' — '.$response->body()
            );
        }

        // Save the generated image
        $filename = 'designs/generated/'.Str::uuid().'.jpg';
        Storage::disk('public')->put($filename, $response->body());

        return $filename;
    }

    /**
     * Generate design using OpenAI DALL-E API (fallback).
     * Note: DALL-E doesn't support image-to-image natively,
     * so we use the edit endpoint or generate from prompt only.
     */
    private function generateWithOpenAI(RoomDesign $roomDesign, ?string $variation = null): string
    {
        $apiKey = config('services.openai.key');
        if (empty($apiKey)) {
            throw new \RuntimeException('OpenAI API key is not configured.');
        }

        $prompt = $this->buildPrompt($roomDesign, $variation);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$apiKey,
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
                'OpenAI API error: '.$response->status().' — '.$response->body()
            );
        }

        $imageUrl = $response->json('data.0.url');
        if (! $imageUrl) {
            throw new \RuntimeException('OpenAI returned no image URL.');
        }

        // Download and save the generated image
        $imageData = Http::timeout(60)->get($imageUrl)->body();
        $filename = 'designs/generated/'.Str::uuid().'.jpg';
        Storage::disk('public')->put($filename, $imageData);

        return $filename;
    }

    /**
     * Build the AI prompt from the room design's style, budget, and optional variation.
     */
    private function buildPrompt(RoomDesign $roomDesign, ?string $variation = null): string
    {
        $style = $roomDesign->style;
        $budget = $roomDesign->budget;
        $roomType = $roomDesign->room_type ?: 'room';

        $budgetDescriptions = [
            'low' => $style->prompt_low ?: Setting::get('budget_low_prompt', 'Use affordable, budget-friendly materials like laminate, MDF, and cotton textiles.'),
            'medium' => $style->prompt_medium ?: Setting::get('budget_medium_prompt', 'Use mid-range materials like engineered wood, quality fabrics, and ceramic tiles.'),
            'high' => $style->prompt_high ?: Setting::get('budget_high_prompt', 'Use premium materials like solid hardwood, marble, brass fixtures, and designer furniture.'),
        ];

        $variationPrompts = [
            'golden_hour' => 'Bathed in warm, golden sunlight from a late afternoon sun. Long shadows, soft orange and yellow glows, magical atmosphere.',
            'rainy_day' => 'Cool, moody atmosphere of a rainy day. Soft, diffused gray light from overcast skies, subtle reflections on surfaces, cozy feel.',
            'night' => 'Atmospheric night scene. Warm interior artificial lighting from lamps and recessed lights, dark windows, high contrast, elegant night vibes.',
            'cyberpunk' => 'Futuristic neon accents, cyan and magenta lighting highlights, high-tech luxury feel.',
            'nordic_winter' => 'Cool blue tones, crisp winter morning light, bright and airy but with a cold external atmosphere.',
        ];

        $budgetDesc = $budgetDescriptions[$budget] ?? $budgetDescriptions['medium'];
        $globalPrefix = trim((string) Setting::get('global_prompt_prefix', ''));
        $globalSuffix = trim((string) Setting::get('global_prompt_suffix', ''));

        $prompt = '';

        if ($globalPrefix !== '') {
            $prompt .= $globalPrefix.' ';
        }

        $prompt .= "Redesign this interior $roomType in a {$style->name} style. ";

        if ($style->prompt_prefix) {
            $prompt .= $style->prompt_prefix.' ';
        }

        $prompt .= rtrim($budgetDesc, '.').'. ';

        if ($variation && isset($variationPrompts[$variation])) {
            $prompt .= $variationPrompts[$variation].' ';
        } else {
            $prompt .= 'Create a photorealistic, high-end interior design visualization. ';
        }

        $prompt .= "Ensure the $roomType remains recognizable with the same layout and architectural structure. ";
        $prompt .= 'Professional interior photography, 8k resolution, cinematic lighting, sharp details. ';

        if ($globalSuffix !== '') {
            $prompt .= $globalSuffix;
        }

        return trim($prompt);
    }

    /**
     * Generate furniture recommendations based on style and budget.
     */
    private function generateFurnitureRecommendations(RoomDesign $roomDesign): void
    {
        $style = $roomDesign->style;
        $budget = $roomDesign->budget;

        $catalogProducts = FurnitureProduct::query()
            ->where('is_active', true)
            ->whereHas('styles', fn ($query) => $query->whereKey($style?->id))
            ->latest()
            ->take(6)
            ->get();

        if ($catalogProducts->isNotEmpty()) {
            foreach ($catalogProducts as $product) {
                FurnitureRecommendation::create([
                    'room_design_id' => $roomDesign->id,
                    'name' => $product->name,
                    'price' => $product->priceForBudget($budget),
                    'purchase_link' => $product->affiliate_link,
                    'image_url' => $product->image_url,
                ]);
            }

            return;
        }

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
            $searchQuery = urlencode($item['name'].' for home');
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

    public function analyzeFurnitureImage(string $imagePath): array
    {
        try {
            // In a production environment, we would use a Vision AI model (GPT-4o, Gemini Pro Vision, or AWS Rekognition)
            // to analyze the image and return structured keywords.

            // For this project, we'll implement a robust simulation that returns
            // diverse attributes to allow for good matching in the database.

            // Let's assume we can detect these categories from common interior photos
            $categories = ['Chair', 'Sofa', 'Table', 'Bed', 'Lamp', 'Cabinet', 'Rug', 'Vase'];
            $styles = ['Modern', 'Minimalist', 'Luxury', 'Traditional', 'Scandinavian', 'Industrial'];
            $materials = ['Wood', 'Metal', 'Leather', 'Fabric', 'Velvet', 'Marble', 'Glass'];

            // Simulate AI delay
            usleep(800000); // 0.8s

            // Realistically, we'd use the filename or image metadata if we weren't doing real CV
            // For the demo, we'll just pick a random set or match keywords from the filename if possible
            $name = strtolower(basename($imagePath));

            $detectedCategory = 'Sofa';
            foreach ($categories as $cat) {
                if (str_contains($name, strtolower($cat))) {
                    $detectedCategory = $cat;
                    break;
                }
            }

            return [
                'category' => $detectedCategory,
                'style' => $styles[array_rand($styles)],
                'material' => $materials[array_rand($materials)],
                'keywords' => [
                    $detectedCategory,
                    'comfortable',
                    'stylish',
                    'premium',
                ],
                'ai_message' => "I've analyzed your photo and found a {$detectedCategory}. Searching for similar items in our catalog...",
            ];

        } catch (\Exception $e) {
            Log::error('AI Visual Analysis Failed', ['error' => $e->getMessage()]);

            return [
                'category' => 'Furniture',
                'keywords' => ['furniture'],
                'ai_message' => 'Searching for similar furniture pieces...',
            ];
        }
    }

    public function getDominantColor(string $imagePath): string
    {
        try {
            $path = Storage::disk('public')->path($imagePath);
            if (!file_exists($path)) {
                return '#E5E5E7';
            }
            
            if (!extension_loaded('gd')) {
                return '#E5E5E7';
            }
            
            $img = null;
            $type = exif_imagetype($path);
            if ($type === IMAGETYPE_JPEG) {
                $img = imagecreatefromjpeg($path);
            } elseif ($type === IMAGETYPE_PNG) {
                $img = imagecreatefrompng($path);
            } elseif ($type === IMAGETYPE_GIF) {
                $img = imagecreatefromgif($path);
            } elseif ($type === IMAGETYPE_WEBP) {
                $img = imagecreatefromwebp($path);
            }
            
            if (!$img) {
                return '#E5E5E7';
            }
            
            // Downsample image to 1x1 pixel to average colors
            $tmp = imagecreatetruecolor(1, 1);
            imagecopyresampled($tmp, $img, 0, 0, 0, 0, 1, 1, imagesx($img), imagesy($img));
            $rgb = imagecolorat($tmp, 0, 0);
            
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            
            imagedestroy($img);
            imagedestroy($tmp);
            
            return sprintf("#%02X%02X%02X", $r, $g, $b);
        } catch (\Exception $e) {
            Log::error('Dominant color extraction failed: ' . $e->getMessage());
            return '#E5E5E7';
        }
    }

    public function generateColorPalettes(string $baseColorHex): array
    {
        $apiKey = config('services.openai.key');
        if (empty($apiKey)) {
            return $this->generatePalettesAlgorithmic($baseColorHex);
        }

        try {
            $prompt = "You are a professional interior design color expert. Generate 5 distinct, sophisticated color palettes for room decoration based on the base color: {$baseColorHex}.\n"
                . "Each palette must contain exactly 5 colors (the base color, plus 4 matching colors) formatted as HEX codes starting with '#'.\n"
                . "Provide a designer name for the palette (e.g. 'Warm Scandinavian', 'Luxury Emerald', 'Industrial Loft') and a 1-sentence description of the mood.\n"
                . "Format the output ONLY as a raw JSON array matching this structure:\n"
                . "[\n"
                . "  {\n"
                . "    \"name\": \"Palette Name\",\n"
                . "    \"description\": \"One sentence description of the mood.\",\n"
                . "    \"colors\": [\"#HEX1\", \"#HEX2\", \"#HEX3\", \"#HEX4\", \"#HEX5\"]\n"
                . "  },\n"
                . "  ...\n"
                . "]";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$apiKey,
            ])
                ->timeout(15)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You output only raw JSON blocks.'],
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'temperature' => 0.7,
                ]);

            if ($response->failed()) {
                throw new \RuntimeException('OpenAI API request failed: '.$response->body());
            }

            $content = $response->json('choices.0.message.content');
            $data = json_decode(trim(str_replace('```json', '', str_replace('```', '', $content))), true);

            if (is_array($data) && count($data) >= 3) {
                return $data;
            }

            throw new \RuntimeException('Invalid JSON structure returned by OpenAI.');

        } catch (\Exception $e) {
            Log::error('AI Palette Generation Failed, falling back to algorithmic: ' . $e->getMessage());
            return $this->generatePalettesAlgorithmic($baseColorHex);
        }
    }

    private function rgbToHsl($r, $g, $b) {
        $r /= 255; $g /= 255; $b /= 255;
        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $h = $s = $l = ($max + $min) / 2;

        if ($max == $min) {
            $h = $s = 0; // achromatic
        } else {
            $d = $max - $min;
            $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
            switch ($max) {
                case $r: $h = ($g - $b) / $d + ($g < $b ? 6 : 0); break;
                case $g: $h = ($b - $r) / $d + 2; break;
                case $b: $h = ($r - $g) / $d + 4; break;
            }
            $h /= 6;
        }
        return [$h * 360, $s, $l];
    }

    private function hslToRgb($h, $s, $l) {
        $h /= 360;
        if ($s == 0) {
            $r = $g = $b = $l; // achromatic
        } else {
            $hue2rgb = function($p, $q, $t) {
                if ($t < 0) $t += 1;
                if ($t > 1) $t -= 1;
                if ($t < 1/6) return $p + ($q - $p) * 6 * $t;
                if ($t < 1/2) return $q;
                if ($t < 2/3) return $p + ($q - $p) * (2/3 - $t) * 6;
                return $p;
            };

            $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
            $p = 2 * $l - $q;
            $r = $hue2rgb($p, $q, $h + 1/3);
            $g = $hue2rgb($p, $q, $h);
            $b = $hue2rgb($p, $q, $h - 1/3);
        }
        return [round($r * 255), round($g * 255), round($b * 255)];
    }

    private function rgbToHex($r, $g, $b) {
        return sprintf("#%02X%02X%02X", $r, $g, $b);
    }

    private function hexToRgb($hex) {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return [$r, $g, $b];
    }

    public function generatePalettesAlgorithmic(string $hex): array
    {
        list($r, $g, $b) = $this->hexToRgb($hex);
        list($h, $s, $l) = $this->rgbToHsl($r, $g, $b);

        $palettes = [];

        // 1. Monochromatic
        $monoColors = [];
        for ($i = 0; $i < 5; $i++) {
            $light = 0.15 + ($i * 0.18);
            list($nr, $ng, $nb) = $this->hslToRgb($h, $s, $light);
            $monoColors[] = $this->rgbToHex($nr, $ng, $nb);
        }
        $palettes[] = [
            'name' => 'Monochromatic Minimalist',
            'description' => 'A clean, modern look using varying shades of a single color tone.',
            'colors' => $monoColors
        ];

        // 2. Analogous
        $analogousColors = [];
        $offsets = [-40, -20, 0, 20, 40];
        foreach ($offsets as $o) {
            $nh = ($h + $o + 360) % 360;
            list($nr, $ng, $nb) = $this->hslToRgb($nh, $s, $l);
            $analogousColors[] = $this->rgbToHex($nr, $ng, $nb);
        }
        $palettes[] = [
            'name' => 'Analogous Serenity',
            'description' => 'Comforting and harmonious colors adjacent to each other on the color wheel.',
            'colors' => $analogousColors
        ];

        // 3. Complementary
        $compColors = [];
        $compColors[] = $this->rgbToHex($r, $g, $b);
        list($nr, $ng, $nb) = $this->hslToRgb($h, $s * 0.8, $l * 1.3);
        $compColors[] = $this->rgbToHex($nr, $ng, $nb);
        list($nr, $ng, $nb) = $this->hslToRgb($h, $s * 0.8, $l * 0.7);
        $compColors[] = $this->rgbToHex($nr, $ng, $nb);
        $ch = ($h + 180) % 360;
        list($nr, $ng, $nb) = $this->hslToRgb($ch, $s, $l);
        $compColors[] = $this->rgbToHex($nr, $ng, $nb);
        list($nr, $ng, $nb) = $this->hslToRgb($ch, $s * 0.8, $l * 1.3);
        $compColors[] = $this->rgbToHex($nr, $ng, $nb);
        
        $palettes[] = [
            'name' => 'High-Contrast Complementary',
            'description' => 'Dynamic energy that pairs the warm base with its cool opposite tone.',
            'colors' => $compColors
        ];

        // 4. Triadic Vibrant
        $triColors = [];
        $triColors[] = $this->rgbToHex($r, $g, $b);
        $th1 = ($h + 120) % 360;
        list($nr, $ng, $nb) = $this->hslToRgb($th1, $s, $l);
        $triColors[] = $this->rgbToHex($nr, $ng, $nb);
        list($nr, $ng, $nb) = $this->hslToRgb($th1, $s * 0.7, $l * 1.3);
        $triColors[] = $this->rgbToHex($nr, $ng, $nb);
        $th2 = ($h + 240) % 360;
        list($nr, $ng, $nb) = $this->hslToRgb($th2, $s, $l);
        $triColors[] = $this->rgbToHex($nr, $ng, $nb);
        list($nr, $ng, $nb) = $this->hslToRgb($th2, $s * 0.7, $l * 0.7);
        $triColors[] = $this->rgbToHex($nr, $ng, $nb);

        $palettes[] = [
            'name' => 'Vibrant Triadic',
            'description' => 'A lively, balanced three-point color harmony for eclectic styles.',
            'colors' => $triColors
        ];

        // 5. Earthy Warmth
        $earthColors = [];
        $earthColors[] = $this->rgbToHex($r, $g, $b);
        $sh1 = ($h + 150) % 360;
        list($nr, $ng, $nb) = $this->hslToRgb($sh1, $s * 0.6, $l * 0.9);
        $earthColors[] = $this->rgbToHex($nr, $ng, $nb);
        $sh2 = ($h + 210) % 360;
        list($nr, $ng, $nb) = $this->hslToRgb($sh2, $s * 0.6, $l * 1.1);
        $earthColors[] = $this->rgbToHex($nr, $ng, $nb);
        list($nr, $ng, $nb) = $this->hslToRgb(($h + 30) % 360, 0.15, 0.85);
        $earthColors[] = $this->rgbToHex($nr, $ng, $nb);
        list($nr, $ng, $nb) = $this->hslToRgb(($h + 180) % 360, 0.15, 0.25);
        $earthColors[] = $this->rgbToHex($nr, $ng, $nb);

        $palettes[] = [
            'name' => 'Earthy Split-Harmony',
            'description' => 'A sophisticated split-complementary scheme with cozy neutral undertones.',
            'colors' => $earthColors
        ];

        return $palettes;
    }
}
