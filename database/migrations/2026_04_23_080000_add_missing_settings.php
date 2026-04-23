<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            // Prompts
            ['key' => 'global_prompt_prefix', 'value' => 'Generate a high-quality interior design for a', 'type' => 'string', 'group' => 'ai'],
            ['key' => 'global_prompt_suffix', 'value' => 'premium quality, 8k resolution, professional photography, cinematic lighting', 'type' => 'string', 'group' => 'ai'],
            
            // Budgets
            ['key' => 'budget_low_label', 'value' => 'Economy', 'type' => 'string', 'group' => 'budget'],
            ['key' => 'budget_low_min', 'value' => '0', 'type' => 'integer', 'group' => 'budget'],
            ['key' => 'budget_low_max', 'value' => '50000', 'type' => 'integer', 'group' => 'budget'],
            ['key' => 'budget_low_prompt', 'value' => 'minimalist, cost-effective materials, practical furniture', 'type' => 'string', 'group' => 'budget'],
            
            ['key' => 'budget_medium_label', 'value' => 'Standard', 'type' => 'string', 'group' => 'budget'],
            ['key' => 'budget_medium_min', 'value' => '50000', 'type' => 'integer', 'group' => 'budget'],
            ['key' => 'budget_medium_max', 'value' => '200000', 'type' => 'integer', 'group' => 'budget'],
            ['key' => 'budget_medium_prompt', 'value' => 'modern finish, balanced decor, quality wood and fabric', 'type' => 'string', 'group' => 'budget'],
            
            ['key' => 'budget_high_label', 'value' => 'Luxury', 'type' => 'string', 'group' => 'budget'],
            ['key' => 'budget_high_min', 'value' => '200000', 'type' => 'integer', 'group' => 'budget'],
            ['key' => 'budget_high_max', 'value' => '1000000', 'type' => 'integer', 'group' => 'budget'],
            ['key' => 'budget_high_prompt', 'value' => 'ultra-luxury, premium marble, designer lighting, exotic materials', 'type' => 'string', 'group' => 'budget'],
            
            // System Limits
            ['key' => 'max_upload_size', 'value' => '10', 'type' => 'integer', 'group' => 'system'],
            ['key' => 'ai_timeout', 'value' => '60', 'type' => 'integer', 'group' => 'ai'],
            
            // Configuration Blobs
            ['key' => 'firebase_config', 'value' => '{}', 'type' => 'json', 'group' => 'system'],
            ['key' => 'smtp_config', 'value' => '{}', 'type' => 'json', 'group' => 'system'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }

    public function down(): void
    {
        // No down migration for seed data usually
    }
};
