<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    /**
     * Get available subscription packages.
     */
    public function packages(Request $request)
    {
        $user = $request->user();
        $activeSubscription = UserSubscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->first();

        $packages = [
            // ... [omitted for brevity, keeping original packages] ...
        ];

        // Standardized package list as defined in previous turn
        $packages = [
            [
                'id' => 1,
                'name' => 'Basic',
                'translated_name' => 'Basic',
                'ios_product_id' => '',
                'package_type' => 'monthly',
                'price' => 0,
                'duration' => 30,
                'created_at' => now()->toDateTimeString(),
                'package_status' => '1',
                'features' => [
                    ['id' => 1, 'name' => '5 Designs', 'translated_name' => '5 Designs', 'limit_type' => 'limited', 'limit' => 5],
                    ['id' => 2, 'name' => 'Standard Resolution', 'translated_name' => 'Standard Resolution', 'limit_type' => 'unlimited', 'limit' => 0],
                ]
            ],
            [
                'id' => 2,
                'name' => 'Pro',
                'translated_name' => 'Pro',
                'ios_product_id' => 'com.homiq.pro.monthly',
                'package_type' => 'monthly',
                'price' => 499,
                'duration' => 30,
                'created_at' => now()->toDateTimeString(),
                'package_status' => '1',
                'features' => [
                    ['id' => 1, 'name' => '50 Designs', 'translated_name' => '50 Designs', 'limit_type' => 'limited', 'limit' => 50],
                    ['id' => 2, 'name' => 'HD Resolution', 'translated_name' => 'HD Resolution', 'limit_type' => 'unlimited', 'limit' => 0],
                    ['id' => 3, 'name' => 'Priority Processing', 'translated_name' => 'Priority Processing', 'limit_type' => 'unlimited', 'limit' => 0],
                ]
            ],
            [
                'id' => 3,
                'name' => 'Platinum',
                'translated_name' => 'Platinum',
                'ios_product_id' => 'com.homiq.platinum.monthly',
                'package_type' => 'monthly',
                'price' => 999,
                'duration' => 30,
                'created_at' => now()->toDateTimeString(),
                'package_status' => '1',
                'features' => [
                    ['id' => 1, 'name' => 'Unlimited Designs', 'translated_name' => 'Unlimited Designs', 'limit_type' => 'unlimited', 'limit' => 0],
                    ['id' => 2, 'name' => 'Ultra HD Resolution', 'translated_name' => 'Ultra HD Resolution', 'limit_type' => 'unlimited', 'limit' => 0],
                    ['id' => 3, 'name' => 'Exclusive Styles', 'translated_name' => 'Exclusive Styles', 'limit_type' => 'unlimited', 'limit' => 0],
                    ['id' => 4, 'name' => '24/7 Support', 'translated_name' => '24/7 Support', 'limit_type' => 'unlimited', 'limit' => 0],
                ]
            ],
        ];

        return response()->json([
            'success' => true,
            'message' => 'Packages fetched successfully',
            'data' => $packages,
            'active_packages' => $activeSubscription ? [$activeSubscription] : [],
        ]);
    }

    /**
     * Complete a purchase and activate a subscription.
     */
    public function purchase(Request $request)
    {
        $request->validate([
            'package_id' => 'required|integer',
            'package_name' => 'required|string',
            'transaction_id' => 'required|string',
            'platform' => 'required|string',
            'amount' => 'required',
        ]);

        $user = $request->user();

        // Expire existing active subscriptions
        UserSubscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        $duration = 30; // Default 30 days for monthly
        $startDate = now();
        $endDate = $startDate->copy()->addDays($duration);

        $subscription = UserSubscription::create([
            'user_id' => $user->id,
            'package_id' => $request->package_id,
            'package_name' => $request->package_name,
            'transaction_id' => $request->transaction_id,
            'platform' => $request->platform,
            'amount' => $request->amount,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription activated successfully',
            'data' => $subscription
        ]);
    }
}
