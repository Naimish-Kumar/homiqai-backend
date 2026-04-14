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
        Schema::create('user_subscriptions', function (Blueprint $row) {
            $row->id();
            $row->foreignId('user_id')->constrained()->onDelete('cascade');
            $row->integer('package_id');
            $row->string('package_name');
            $row->string('transaction_id')->unique();
            $row->string('platform'); // ios, android
            $row->decimal('amount', 8, 2);
            $row->string('currency')->default('INR');
            $row->timestamp('start_date');
            $row->timestamp('end_date');
            $row->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $row->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
