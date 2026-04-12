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
        Style::updateOrCreate(['name' => 'Modern'], [
            'name' => 'Modern',
            'thumbnail_url' => 'images/styles/minimalist.png',
            'prompt_prefix' => 'A modern interior design with clean lines, neutral colors, and functional furniture.',
        ]);

        Style::updateOrCreate(['name' => 'Minimal'], [
            'name' => 'Minimal',
            'thumbnail_url' => 'images/styles/minimalist.png',
            'prompt_prefix' => 'A minimalist room with simple furniture, open space, and a white/grey color palette.',
        ]);

        Style::updateOrCreate(['name' => 'Luxury'], [
            'name' => 'Luxury',
            'thumbnail_url' => 'images/hero-studio.png',
            'prompt_prefix' => 'A luxury high-end interior with gold accents, velvet textures, and elegant lighting.',
        ]);

        Style::updateOrCreate(['name' => 'Traditional Indian'], [
            'name' => 'Traditional Indian',
            'thumbnail_url' => 'images/styles/indian.png',
            'prompt_prefix' => 'A traditional Indian home interior with vibrant colors, teak wood furniture, and ethnic patterns.',
        ]);

        Style::updateOrCreate(['name' => 'Scandinavian'], [
            'name' => 'Scandinavian',
            'thumbnail_url' => 'images/styles/scandinavian.png',
            'prompt_prefix' => 'A Scandinavian design with light wood, cozy textiles, and a bright, airy atmosphere.',
        ]);
    }
}
