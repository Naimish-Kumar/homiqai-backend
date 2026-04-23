<?php

namespace Database\Seeders;

use App\Models\FurnitureProduct;
use App\Models\Style;
use Illuminate\Database\Seeder;

class FurnitureSeeder extends Seeder
{
    public function run(): void
    {
        $modern = Style::where('name', 'Modern')->first();
        $minimal = Style::where('name', 'Minimal')->first();
        $luxury = Style::where('name', 'Luxury')->first();
        $indian = Style::where('name', 'Traditional Indian')->first();
        $scandinavian = Style::where('name', 'Scandinavian')->first();

        $products = [
            [
                'name' => 'Emerald Velvet Sofa',
                'category' => 'Seating',
                'brand' => 'Homiq Luxe',
                'image_url' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=2070&auto=format&fit=crop',
                'affiliate_link' => 'https://example.com/sofa',
                'low_price' => 25000,
                'medium_price' => 45000,
                'high_price' => 85000,
                'styles' => [$modern->id, $luxury->id]
            ],
            [
                'name' => 'Marble Top Coffee Table',
                'category' => 'Tables',
                'brand' => 'Nordic Designs',
                'image_url' => 'https://images.unsplash.com/photo-1533090161767-e6ffed986c88?q=80&w=2069&auto=format&fit=crop',
                'affiliate_link' => 'https://example.com/table',
                'low_price' => 5000,
                'medium_price' => 12000,
                'high_price' => 25000,
                'styles' => [$minimal->id, $modern->id, $scandinavian->id]
            ],
            [
                'name' => 'Art Deco Gold Pendant',
                'category' => 'Lighting',
                'brand' => 'Aura Lighting',
                'image_url' => 'https://images.unsplash.com/photo-1543198126-a8ad8e47fb21?q=80&w=1974&auto=format&fit=crop',
                'affiliate_link' => 'https://example.com/light',
                'low_price' => 2000,
                'medium_price' => 8000,
                'high_price' => 15000,
                'styles' => [$luxury->id]
            ],
            [
                'name' => 'Royal Teak Armchair',
                'category' => 'Seating',
                'brand' => 'Heritage India',
                'image_url' => 'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?q=80&w=1974&auto=format&fit=crop',
                'affiliate_link' => 'https://example.com/chair',
                'low_price' => 12000,
                'medium_price' => 25000,
                'high_price' => 45000,
                'styles' => [$indian->id]
            ],
            [
                'name' => 'Minimalist Oak Bed',
                'category' => 'Bedroom',
                'brand' => 'Zen Living',
                'image_url' => 'https://images.unsplash.com/photo-1505693419148-ad3097f98751?q=80&w=2070&auto=format&fit=crop',
                'affiliate_link' => 'https://example.com/bed',
                'low_price' => 18000,
                'medium_price' => 35000,
                'high_price' => 65000,
                'styles' => [$minimal->id, $scandinavian->id]
            ],
            [
                'name' => 'Floating Wall Shelf',
                'category' => 'Storage',
                'brand' => 'Nordic Designs',
                'image_url' => 'https://images.unsplash.com/photo-1594620302200-9a762244a156?q=80&w=2039&auto=format&fit=crop',
                'affiliate_link' => 'https://example.com/shelf',
                'low_price' => 1500,
                'medium_price' => 3000,
                'high_price' => 6000,
                'styles' => [$minimal->id, $modern->id]
            ],
        ];

        foreach ($products as $p) {
            $styles = $p['styles'];
            unset($p['styles']);
            $product = FurnitureProduct::create($p);
            $product->styles()->attach($styles);
        }
    }
}
