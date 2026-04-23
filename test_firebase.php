<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\FirebaseService;

$service = new FirebaseService();
echo "Testing Firebase Access Token Generation...\n";
try {
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('getAccessToken');
    $method->setAccessible(true);
    
    $config = json_decode(App\Models\Setting::get('firebase_config'), true);
    if (!$config) {
        die("Error: Firebase config is not a valid JSON in database.\n");
    }
    
    $token = $method->invoke($service, $config);
    if ($token) {
        echo "Success! Access Token generated: " . substr($token, 0, 20) . "...\n";
    } else {
        echo "Failed to generate Access Token. Check your private key and client email.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
