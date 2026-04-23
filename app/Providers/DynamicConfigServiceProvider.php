<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

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
            if (Setting::tableIsAvailable()) {
                $settings = Setting::safeKeyedValues()
                    ->mapWithKeys(fn (Setting $setting) => [$setting->key => $setting->value])
                    ->toArray();

                $this->applyConfig($settings);
                return;
            }
        } catch (\Throwable $e) {
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
            'services.apple.shared_secret' => $settings['apple_shared_secret'] ?? config('services.apple.shared_secret'),
            'services.google_play.package_name' => $settings['google_package_name'] ?? config('services.google_play.package_name'),
        ]);

        // Apply SMTP Config
        if (isset($settings['smtp_config'])) {
            $smtp = json_decode($settings['smtp_config'], true);
            if (is_array($smtp)) {
                config([
                    'mail.mailers.smtp.transport' => $smtp['transport'] ?? 'smtp',
                    'mail.mailers.smtp.host' => $smtp['host'] ?? config('mail.mailers.smtp.host'),
                    'mail.mailers.smtp.port' => $smtp['port'] ?? config('mail.mailers.smtp.port'),
                    'mail.mailers.smtp.encryption' => $smtp['encryption'] ?? config('mail.mailers.smtp.encryption'),
                    'mail.mailers.smtp.username' => $smtp['username'] ?? config('mail.mailers.smtp.username'),
                    'mail.mailers.smtp.password' => $smtp['password'] ?? config('mail.mailers.smtp.password'),
                    'mail.from.address' => $smtp['from_address'] ?? config('mail.from.address'),
                    'mail.from.name' => $smtp['from_name'] ?? config('mail.from.name'),
                    'mail.default' => 'smtp',
                ]);
            }
        }
    }
}
