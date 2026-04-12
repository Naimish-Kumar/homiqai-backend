<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $col) {
            $col->string('mobile')->nullable()->unique()->after('email');
            $col->string('google_id')->nullable()->unique()->after('mobile');
            $col->string('apple_id')->nullable()->unique()->after('google_id');
            $col->string('otp_code')->nullable()->after('password');
            $col->timestamp('otp_expires_at')->nullable()->after('otp_code');
            $col->timestamp('otp_verified_at')->nullable()->after('otp_expires_at');
            $col->string('password')->nullable()->change(); // Make password nullable as we use OTP/Social
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $col) {
            $col->dropColumn(['mobile', 'google_id', 'apple_id', 'otp_code', 'otp_expires_at', 'otp_verified_at']);
            $col->string('password')->nullable(false)->change();
        });
    }
};
