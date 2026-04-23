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
        $response = Http::withToken($token)->post($url, [
            'message' => [
                'token' => $targetToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data,
            ],
        ]);

        if ($response->failed()) {
            Log::error('FCM Send Error', ['response' => $response->json()]);
            return false;
        }

        return true;
    }

    private function sendToTopic($url, $token, $topic, $title, $body, $data)
    {
        $response = Http::withToken($token)->post($url, [
            'message' => [
                'topic' => $topic,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data,
            ],
        ]);

        return $response->successful();
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
