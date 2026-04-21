<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class DynamicConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Try loading from Database first
        try {
            if (Schema::hasTable('settings')) {
                $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
                $this->applyConfig($settings);
                return;
            }
        } catch (\Exception $e) {
            // Database not ready or table missing, fallback to file
        }

        // Fallback to JSON file
        $settingsPath = storage_path('app/settings.json');
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
            if (is_array($settings)) {
                $this->applyConfig($settings);
            }
        }
    }

    protected function applyConfig(array $settings): void
    {
        config([
            'services.ai.provider' => $settings['ai_provider'] ?? $settings['ai_provider'] ?? config('services.ai.provider'),
            'services.stability_ai.key' => $settings['stability_ai_key'] ?? $settings['stability_ai_key'] ?? config('services.stability_ai.key'),
            'services.openai.key' => $settings['openai_key'] ?? $settings['openai_key'] ?? config('services.openai.key'),
            'services.affiliate.amazon_tag' => $settings['amazon_affiliate_tag'] ?? $settings['amazon_affiliate_tag'] ?? config('services.affiliate.amazon_tag'),
            'services.apple.shared_secret' => $settings['apple_shared_secret'] ?? $settings['apple_shared_secret'] ?? config('services.apple.shared_secret'),
            'services.google_play.package_name' => $settings['google_package_name'] ?? $settings['google_package_name'] ?? config('services.google_play.package_name'),
        ]);
    }
}
