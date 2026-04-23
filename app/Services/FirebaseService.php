<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    /**
     * Send a push notification to a specific user or all users.
     */
    public function sendPush($title, $body, $userId = null, $data = [])
    {
        $config = json_decode(Setting::get('firebase_config', '{}'), true);
        
        if (empty($config) || !isset($config['project_id'])) {
            Log::error('Firebase configuration is missing or invalid.');
            return false;
        }

        $projectId = $config['project_id'];
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        // Get the access token
        $accessToken = $this->getAccessToken($config);
        if (!$accessToken) {
            Log::error('Failed to generate Firebase access token.');
            return false;
        }

        if ($userId) {
            $user = User::find($userId);
            if ($user && $user->fcm_id) {
                return $this->sendToToken($url, $accessToken, $user->fcm_id, $title, $body, $data);
            }
        } else {
            // Send to a topic (e.g., 'all') or loop through users
            return $this->sendToTopic($url, $accessToken, 'all', $title, $body, $data);
        }

        return false;
    }

    private function sendToToken($url, $token, $targetToken, $title, $body, $data)
    {
        $payload = [
            'message' => [
                'token' => $targetToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data,
                'android' => [
                    'priority' => 'high',
                    'notification' => [
                        'channel_id' => 'homiq_channel',
                    ],
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'content-available' => 1,
                        ],
                    ],
                ],
            ],
        ];

        Log::debug('FCM Sending Payload', $payload);

        $response = Http::withToken($token)->post($url, $payload);

        if ($response->failed()) {
            Log::error('FCM Send Error (Token)', [
                'token' => $targetToken,
                'response' => $response->json(),
                'status' => $response->status()
            ]);
            return false;
        }

        Log::info('FCM Sent Success (Token)', ['token' => $targetToken]);

        return true;
    }

    private function sendToTopic($url, $token, $topic, $title, $body, $data)
    {
        $payload = [
            'message' => [
                'topic' => $topic,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data,
                'android' => [
                    'priority' => 'high',
                    'notification' => [
                        'channel_id' => 'homiq_channel',
                    ],
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'content-available' => 1,
                        ],
                    ],
                ],
            ],
        ];

        Log::debug('FCM Sending Payload (Topic)', $payload);

        $response = Http::withToken($token)->post($url, $payload);

        if ($response->failed()) {
            Log::error('FCM Send Error (Topic)', [
                'topic' => $topic,
                'response' => $response->json(),
                'status' => $response->status()
            ]);
            return false;
        }

        Log::info('FCM Sent Success (Topic)', ['topic' => $topic]);
        return true;
    }

    private function getAccessToken($config)
    {
        $now = time();
        $header = json_encode(['alg' => 'RS256', 'typ' => 'JWT']);
        $payload = json_encode([
            'iss' => $config['client_email'],
            'scope' => 'https://www.googleapis.com/auth/cloud-platform',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now,
        ]);

        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);

        $signature = '';
        $success = openssl_sign(
            $base64UrlHeader . "." . $base64UrlPayload,
            $signature,
            $config['private_key'],
            'SHA256'
        );

        if (!$success) return null;

        $base64UrlSignature = $this->base64UrlEncode($signature);
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        return $response->json('access_token');
    }

    private function base64UrlEncode($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }
}
