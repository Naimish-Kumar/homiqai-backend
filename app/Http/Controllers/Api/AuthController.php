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

            // Send OTP via Email
            if ($type === 'email') {
                \Illuminate\Support\Facades\Mail::to($identifier)->send(new \App\Mail\SendOtpMail($otp));
            }

            // Send OTP via Mobile (Using Firebase Push as requested)
            if ($type === 'mobile') {
                $firebase = app(\App\Services\FirebaseService::class);
                if ($user->fcm_id) {
                    $firebase->sendPush(
                        'Your Homiq OTP',
                        "Your verification code is: {$otp}",
                        $user->id,
                        ['otp' => (string)$otp, 'type' => 'otp_verification']
                    );
                } else {
                    // If no FCM ID, we can't send a push. 
                    // Note: For real SMS, a provider like Twilio/Msg91 is needed.
                    Log::warning("Cannot send Push OTP to {$identifier}: No FCM ID found.");
                }
            }

            Log::info("OTP for {$identifier}: {$otp}");

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
                'debug_otp' => config('app.debug') ? $otp : null
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

        if ($user->is_blocked) {
            return response()->json([
                'success' => false,
                'message' => 'Your account has been blocked. Please contact support.',
            ], 403);
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

        return $this->issueToken($user, $request->fcm_id);
    }

    /**
     * Firebase Login (Phone/Social)
     * Verifies the Firebase ID Token and logs the user in
     */
    public function firebaseLogin(Request $request)
    {
        $request->validate([
            'id_token' => 'required|string',
            'provider' => 'required|string', // e.g., 'phone', 'google.com'
        ]);

        try {
            // In a real production app, we should verify the ID token signature 
            // using Google's public keys. For now, we'll decode and verify the claims.
            $tokenParts = explode('.', $request->id_token);
            if (count($tokenParts) !== 3) {
                throw new \Exception('Invalid token format');
            }

            $payload = json_decode(base64_decode($tokenParts[1]), true);
            
            if (!$payload || !isset($payload['sub'])) {
                throw new \Exception('Invalid token payload');
            }

            // Verify project ID
            $firebaseConfig = json_decode(\App\Models\Setting::get('firebase_config', '{}'), true);
            $expectedProjectId = $firebaseConfig['project_id'] ?? null;
            
            if ($expectedProjectId && $payload['aud'] !== $expectedProjectId) {
                throw new \Exception('Invalid token audience');
            }

            $firebaseUid = $payload['sub'];
            $phoneNumber = $payload['phone_number'] ?? null;
            $email = $payload['email'] ?? null;
            $name = $payload['name'] ?? null;

            // Find or create user
            $user = null;
            if ($phoneNumber) {
                $user = User::where('mobile', $phoneNumber)->first();
            } elseif ($email) {
                $user = User::where('email', $email)->first();
            }

            if (!$user) {
                $user = User::create([
                    'name' => $name ?? 'User_' . Str::random(5),
                    'email' => $email,
                    'mobile' => $phoneNumber,
                    'google_id' => ($request->provider === 'google.com') ? $firebaseUid : null,
                ]);
            } else {
                // Update missing fields
                if ($phoneNumber && !$user->mobile) $user->mobile = $phoneNumber;
                if ($email && !$user->email) $user->email = $email;
                $user->save();
            }

            return $this->issueToken($user, $request->fcm_id);

        } catch (\Exception $e) {
            Log::error('FirebaseLogin Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Firebase authentication failed: ' . $e->getMessage(),
            ], 401);
        }
    }

    private function issueToken($user, $fcmId = null)
    {
        if ($user->is_blocked) {
            return response()->json([
                'success' => false,
                'message' => 'Your account has been blocked. Please contact support.',
            ], 403);
        }

        // Update FCM token if provided
        if ($fcmId) {
            $user->fcm_id = $fcmId;
            $user->save();
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'access_token' => $token,
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

    /**
     * Update User Profile
     */
    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();

            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'phone_number' => 'nullable|string|max:20',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->has('name')) {
                $user->name = $request->name;
            }

            if ($request->has('email')) {
                $user->email = $request->email;
            }

            if ($request->has('phone_number')) {
                $user->mobile = $request->phone_number;
            }

            if ($request->hasFile('profile')) {
                // Delete old profile if exists and it's a local file
                if ($user->profile && !\Str::startsWith($user->profile, 'http') && \Storage::disk('public')->exists($user->profile)) {
                    \Storage::disk('public')->delete($user->profile);
                }

                $path = $request->file('profile')->store('profiles', 'public');
                $user->profile = $path;
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'user' => $user->fresh() // fresh() to include appends/new fields
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('UpdateProfile Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile. ' . (config('app.debug') ? $e->getMessage() : ''),
            ], 500);
        }
    }

    /**
     * Update FCM Token for Push Notifications
     */
    public function updateFcmToken(Request $request)
    {
        $request->validate([
            'fcm_id' => 'required|string',
        ]);

        $user = $request->user();
        $user->fcm_id = $request->fcm_id;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'FCM token updated successfully',
        ]);
    }
}
