<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Fix: Make 'email' nullable so users can register with only a phone number.
     * Add 'fcm_id' column for push notification support.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Only change nullable — don't re-add unique (it already exists)
            $table->string('email')->nullable()->change();

            if (!Schema::hasColumn('users', 'fcm_id')) {
                $table->string('fcm_id')->nullable()->after('apple_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
            $table->dropColumn('fcm_id');
        });
    }
};
