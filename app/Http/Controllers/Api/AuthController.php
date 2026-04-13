<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Send OTP to Email or Mobile
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string', // Email or Mobile
            'type' => 'required|in:email,mobile',
        ]);

        $identifier = $request->identifier;
        $type = $request->type;

        try {
            // Find or create user
            $user = User::where($type, $identifier)->first();
            
            if (!$user) {
                $userData = [
                    'name' => 'User_' . Str::random(5),
                    $type => $identifier,
                ];

                // Set nullable fields explicitly for new phone-only users
                if ($type === 'mobile') {
                    $userData['email'] = null;
                } else {
                    $userData['mobile'] = null;
                }

                $user = User::create($userData);
            }

            // Generate OTP
            $otp = rand(100000, 999999);
            $user->otp_code = $otp;
            $user->otp_expires_at = Carbon::now()->addMinutes(10);
            $user->save();

            // Send OTP (Currently via Log)
            Log::info("OTP for {$identifier}: {$otp}");

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
                'debug_otp' => config('app.debug') ? $otp : null // Send OTP in response only in debug mode
            ]);

        } catch (\Exception $e) {
            Log::error('SendOTP Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.',
            ], 500);
        }
    }

    /**
     * Verify OTP and Login
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'type' => 'required|in:email,mobile',
            'otp' => 'required|string|size:6',
        ]);

        $user = User::where($request->type, $request->identifier)
            ->where('otp_code', $request->otp)
            ->where('otp_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP'
            ], 401);
        }

        // Clear OTP and mark verified
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->otp_verified_at = Carbon::now();

        // Update FCM token if provided
        if ($request->filled('fcm_id')) {
            $user->fcm_id = $request->fcm_id;
        }

        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,              // Flutter reads 'token'
            'access_token' => $token,       // Keep for backward compatibility
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    /**
     * Social Login (Google/Apple)
     */
    public function socialLogin(Request $request)
    {
        $request->validate([
            'provider' => 'required|in:google,apple',
            'social_id' => 'required|string',
            'email' => 'required|email',
            'name' => 'nullable|string',
        ]);

        $providerField = $request->provider . '_id';

        // Find user by social ID or email
        $user = User::where($providerField, $request->social_id)
            ->orWhere('email', $request->email)
            ->first();

        if ($user) {
            // Update social ID if missing
            if (!$user->$providerField) {
                $user->$providerField = $request->social_id;
                $user->save();
            }
        } else {
            // Create new user
            $user = User::create([
                'name' => $request->name ?? 'Social User',
                'email' => $request->email,
                $providerField => $request->social_id,
            ]);
        }

        // Update FCM token if provided
        if ($request->filled('fcm_id')) {
            $user->fcm_id = $request->fcm_id;
        }
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,              // Flutter reads 'token'
            'access_token' => $token,       // Keep for backward compatibility
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out'
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user()
        ]);
    }
}
