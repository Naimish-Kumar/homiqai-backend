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
            'prompt_low' => 'Use affordable modern materials like laminate surfaces, IKEA-style modular furniture, and cotton upholstery.',
            'prompt_medium' => 'Use quality modern materials like engineered wood, sleek metal accents, and premium polyester fabrics.',
            'prompt_high' => 'Use luxury modern materials like Italian marble, solid walnut wood, designer leather furniture, and custom architectural lighting.',
        ]);

        Style::updateOrCreate(['name' => 'Minimal'], [
            'name' => 'Minimal',
            'thumbnail_url' => 'images/styles/minimalist.png',
            'prompt_prefix' => 'A minimalist room with simple furniture, open space, and a white/grey color palette.',
            'prompt_low' => 'Focus on essential pieces with plain white walls, basic grey rugs, and simple black metal frames.',
            'prompt_medium' => 'Use refined minimalism with textured off-white walls, high-quality linen textiles, and hidden storage solutions.',
            'prompt_high' => 'Achieve ultra-luxury minimalism with seamless micro-cement floors, bespoke hidden cabinetry, and museum-grade negative space design.',
        ]);

        Style::updateOrCreate(['name' => 'Luxury'], [
            'name' => 'Luxury',
            'thumbnail_url' => 'images/hero-studio.png',
            'prompt_prefix' => 'A luxury high-end interior with gold accents, velvet textures, and elegant lighting.',
            'prompt_low' => 'Use faux-gold finishes, plush velvet-like fabrics, and statement lighting fixtures that look expensive.',
            'prompt_medium' => 'Use genuine brass accents, high-thread-count velvet, crystal light fixtures, and polished porcelain flooring.',
            'prompt_high' => 'Incorporate 24k gold leaf detailing, exotic stone cladding, Swarovski chandeliers, and custom-made velvet designer furniture.',
        ]);

        Style::updateOrCreate(['name' => 'Traditional Indian'], [
            'name' => 'Traditional Indian',
            'thumbnail_url' => 'images/styles/indian.png',
            'prompt_prefix' => 'A traditional Indian home interior with vibrant colors, teak wood furniture, and ethnic patterns.',
            'prompt_low' => 'Use colorful cotton tapestries, basic sheesham wood furniture, and terracotta decorative elements.',
            'prompt_medium' => 'Use hand-carved teak wood, silk blend upholstery, Jaisalmer stone accents, and traditional brass lamps.',
            'prompt_high' => 'Feature intricate antique wood carvings, pure silk textiles, hand-painted murals, and premium Makrana marble flooring.',
        ]);

        Style::updateOrCreate(['name' => 'Scandinavian'], [
            'name' => 'Scandinavian',
            'thumbnail_url' => 'images/styles/scandinavian.png',
            'prompt_prefix' => 'A Scandinavian design with light wood, cozy textiles, and a bright, airy atmosphere.',
            'prompt_low' => 'Use light pine wood finishes, basic white furniture, and cozy fleece throws.',
            'prompt_medium' => 'Use white oak furniture, wool rugs, organic cotton textiles, and iconic Nordic lighting designs.',
            'prompt_high' => 'Incorporate solid ash wood architectural elements, Icelandic sheepskin, premium Hans Wegner-style furniture, and floor-to-ceiling glass.',
        ]);
    }
}
