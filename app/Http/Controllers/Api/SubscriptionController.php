<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
     * Supports Razorpay, iOS App Store, and Google Play receipts.
     */
    public function purchase(Request $request)
    {
        $request->validate([
            'package_id' => 'required|integer',
            'package_name' => 'required|string',
            'transaction_id' => 'required|string',
            'platform' => 'required|string',
            'amount' => 'required',
            'razorpay_order_id' => 'nullable|string',
            'razorpay_signature' => 'nullable|string',
            'receipt_data' => 'nullable|string',
            'product_id' => 'nullable|string',
        ]);

        $user = $request->user();

        // ─── Server-side payment verification ────────────────────────────

        // 1. Razorpay verification
        if ($request->platform === 'razorpay' && config('razorpay.key_secret')) {
            $razorpaySignature = $request->razorpay_signature;
            $razorpayOrderId = $request->razorpay_order_id;
            $transactionId = $request->transaction_id;

            if ($razorpaySignature && $razorpayOrderId) {
                $expectedSignature = hash_hmac(
                    'sha256',
                    $razorpayOrderId . '|' . $transactionId,
                    config('razorpay.key_secret')
                );

                if (!hash_equals($expectedSignature, $razorpaySignature)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Payment verification failed. Invalid signature.',
                    ], 422);
                }
            }
        }

        // 2. iOS App Store receipt verification
        if ($request->platform === 'ios' && $request->filled('receipt_data')) {
            $verified = $this->verifyAppleReceipt($request->receipt_data);
            if (!$verified) {
                return response()->json([
                    'success' => false,
                    'message' => 'iOS receipt verification failed.',
                ], 422);
            }
        }

        // 3. Google Play purchase token verification
        if ($request->platform === 'android' && $request->filled('receipt_data') && $request->filled('product_id')) {
            $verified = $this->verifyGooglePurchase(
                $request->product_id,
                $request->receipt_data
            );
            if (!$verified) {
                return response()->json([
                    'success' => false,
                    'message' => 'Google Play purchase verification failed.',
                ], 422);
            }
        }

        // ─── Activate subscription ───────────────────────────────────────

        // Prevent duplicate transactions
        $existingTransaction = UserSubscription::where('transaction_id', $request->transaction_id)->first();
        if ($existingTransaction) {
            return response()->json([
                'success' => true,
                'message' => 'Subscription already active for this transaction',
                'data' => $existingTransaction,
            ]);
        }

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

        // Mark user as premium
        $user->update(['is_premium' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription activated successfully',
            'data' => $subscription
        ]);
    }

    /**
     * Verify an iOS App Store receipt with Apple's verifyReceipt endpoint.
     * Uses production URL first; falls back to sandbox for TestFlight/dev.
     */
    private function verifyAppleReceipt(string $receiptData): bool
    {
        $sharedSecret = config('services.apple.shared_secret');

        // If no shared secret is configured, log a warning and trust the client
        if (empty($sharedSecret)) {
            Log::warning('Apple shared secret not configured — skipping receipt verification');
            return true;
        }

        $payload = [
            'receipt-data' => $receiptData,
            'password' => $sharedSecret,
            'exclude-old-transactions' => true,
        ];

        try {
            // Try production first
            $response = Http::timeout(30)->post(
                'https://buy.itunes.apple.com/verifyReceipt',
                $payload
            );

            $result = $response->json();

            // Status 21007 means this receipt is from the sandbox
            if (($result['status'] ?? -1) === 21007) {
                $response = Http::timeout(30)->post(
                    'https://sandbox.itunes.apple.com/verifyReceipt',
                    $payload
                );
                $result = $response->json();
            }

            $isValid = ($result['status'] ?? -1) === 0;

            if (!$isValid) {
                Log::warning('Apple receipt verification failed', ['status' => $result['status'] ?? 'unknown']);
            }

            return $isValid;
        } catch (\Exception $e) {
            Log::error('Apple receipt verification error: ' . $e->getMessage());
            // On network error, trust the client to avoid blocking legitimate users
            return true;
        }
    }

    /**
     * Verify a Google Play purchase token.
     * Requires GOOGLE_PLAY_PACKAGE_NAME in config.
     * Falls back to trusting the client if credentials are not configured.
     */
    private function verifyGooglePurchase(string $productId, string $purchaseToken): bool
    {
        $packageName = config('services.google_play.package_name', 'com.homiq.app');
        $serviceAccountJson = config('services.google_play.service_account_json');

        // If no service account is configured, log a warning and trust the client
        if (empty($serviceAccountJson)) {
            Log::warning('Google Play service account not configured — skipping purchase verification');
            return true;
        }

        try {
            // Get an OAuth2 access token from the service account
            $accessToken = $this->getGoogleAccessToken($serviceAccountJson);
            if (!$accessToken) {
                Log::warning('Could not obtain Google access token — trusting client');
                return true;
            }

            $url = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{$packageName}/purchases/subscriptions/{$productId}/tokens/{$purchaseToken}";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->timeout(30)->get($url);

            if ($response->successful()) {
                $data = $response->json();
                // paymentState: 0 = pending, 1 = received, 2 = free trial
                $paymentState = $data['paymentState'] ?? -1;
                $isValid = in_array($paymentState, [1, 2]);

                if (!$isValid) {
                    Log::warning('Google Play payment state invalid', ['state' => $paymentState]);
                }

                return $isValid;
            }

            Log::warning('Google Play API returned error', ['status' => $response->status()]);
            return false;
        } catch (\Exception $e) {
            Log::error('Google Play verification error: ' . $e->getMessage());
            // On network error, trust the client
            return true;
        }
    }

    /**
     * Get the current subscription status for the authenticated user.
     */
    public function status(Request $request)
    {
        $user = $request->user();
        $subscription = UserSubscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->first();

        $cancellationMessage = "To cancel your subscription, please visit your account settings in the ";
        if ($subscription) {
            if ($subscription->platform === 'ios') {
                $cancellationMessage .= "Apple App Store.";
            } elseif ($subscription->platform === 'android') {
                $cancellationMessage .= "Google Play Store.";
            } else {
                $cancellationMessage .= "payment provider's portal.";
            }
        }

        return response()->json([
            'success' => true,
            'subscription' => $subscription,
            'is_premium' => (bool)$user->is_premium,
            'cancellation_instructions' => $subscription ? $cancellationMessage : null,
        ]);
    }

    /**
     * Get a Google OAuth2 access token from a service account JSON key.
     */
    private function getGoogleAccessToken(string $serviceAccountJsonPath): ?string
    {
        try {
            if (!file_exists($serviceAccountJsonPath)) {
                return null;
            }

            $serviceAccount = json_decode(file_get_contents($serviceAccountJsonPath), true);
            $now = time();

            // Build JWT
            $header = base64_encode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
            $claims = base64_encode(json_encode([
                'iss' => $serviceAccount['client_email'],
                'scope' => 'https://www.googleapis.com/auth/androidpublisher',
                'aud' => 'https://oauth2.googleapis.com/token',
                'iat' => $now,
                'exp' => $now + 3600,
            ]));

            $signatureInput = "$header.$claims";
            openssl_sign($signatureInput, $signature, $serviceAccount['private_key'], 'sha256');
            $jwt = "$signatureInput." . base64_encode($signature);

            $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ]);

            return $response->json('access_token');
        } catch (\Exception $e) {
            Log::error('Google OAuth token error: ' . $e->getMessage());
            return null;
        }
    }
}