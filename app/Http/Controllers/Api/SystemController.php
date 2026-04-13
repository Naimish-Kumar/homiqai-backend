<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    /**
     * Get initial application settings.
     * Enriched to satisfy FetchSystemSettingsCubit parsing.
     */
    public function index()
    {
        return response()->json([
            'error' => false,
            'message' => 'Settings fetched successfully',
            'data' => [
                // Theme & Assets (Luxury Midnight & Neon Blue Palette)
                'light_tertiary' => '#EDF2F7',
                'placeholder_logo' => asset('images/logo.png'),
                'light_secondary' => '#F8FAFC',
                'light_primary' => '#0052FF', // Electric Azure
                'dark_tertiary' => '#151B2E',
                'dark_secondary' => '#0A0E1A',
                'dark_primary' => '#3A86FF', // Neon Blue Accent
                'app_home_screen' => asset('images/logo.png'),
                'is_active' => true,

                // Mandatory fields for Cubit
                'languages' => [
                    ['id' => '1', 'code' => 'en', 'name' => 'English']
                ],
                'currency_symbol' => '₹',
                'selected_currency_data' => [
                    'code' => 'INR',
                    'symbol' => '₹'
                ],
                'place_api_key' => null,
                'show_admob_ads' => '0',
                'home_page_location_alert_status' => '0',
                'distance_option' => 'km',
                'playstore_id' => 'com.homiq.app',
                'appstore_id' => '0',
                'otp_service_provider' => 'firebase',
                'verification_required_for_user' => false,
                'bank_details' => [],
                'min_radius_range' => '0',
                'max_radius_range' => '50',
                'latitude' => '20.5937',
                'longitude' => '78.9629'
            ]
        ]);
    }

    /**
     * Get available languages.
     */
    public function languages()
    {
        return response()->json([
            'error' => false,
            'data' => [
                ['id' => '1', 'code' => 'en', 'name' => 'English']
            ]
        ]);
    }

    /**
     * Get payment settings.
     */
    public function paymentSettings()
    {
        return response()->json([
            'error' => false,
            'message' => 'Payment settings fetched successfully',
            'data' => [
                'bank_transfer_status' => '0',
                'flutterwave_status' => '0',
                'razor_key' => null,
                'paystack_public_key' => null,
                'paystack_currency' => 'INR',
                'stripe_currency' => 'INR',
                'stripe_publishable_key' => null,
                'stripe_secret_key' => null,
                'paypal_gateway' => '0',
                'razorpay_gateway' => '0',
                'paystack_gateway' => '0',
                'stripe_gateway' => '0',
                'paypal_client_id' => null
            ]
        ]);
    }
}
