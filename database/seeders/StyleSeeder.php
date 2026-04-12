<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Style;

class StyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Style::create([
            'name' => 'Modern',
            'thumbnail_url' => 'https://example.com/styles/modern.jpg',
            'prompt_prefix' => 'A modern interior design with clean lines, neutral colors, and functional furniture.',
        ]);

        Style::create([
            'name' => 'Minimal',
            'thumbnail_url' => 'https://example.com/styles/minimal.jpg',
            'prompt_prefix' => 'A minimalist room with simple furniture, open space, and a white/grey color palette.',
        ]);

        Style::create([
            'name' => 'Luxury',
            'thumbnail_url' => 'https://example.com/styles/luxury.jpg',
            'prompt_prefix' => 'A luxury high-end interior with gold accents, velvet textures, and elegant lighting.',
        ]);

        Style::create([
            'name' => 'Traditional Indian',
            'thumbnail_url' => 'https://example.com/styles/indian.jpg',
            'prompt_prefix' => 'A traditional Indian home interior with vibrant colors, teak wood furniture, and ethnic patterns.',
        ]);

        Style::create([
            'name' => 'Scandinavian',
            'thumbnail_url' => 'https://example.com/styles/scandinavian.jpg',
            'prompt_prefix' => 'A Scandinavian design with light wood, cozy textiles, and a bright, airy atmosphere.',
        ]);
    }
}
