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
        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('budget_limit', 12, 2)->nullable()->default(3000.00);
        });

        Schema::table('layouts', function (Blueprint $table) {
            $table->json('items')->nullable();
            $table->decimal('total_price', 12, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layouts', function (Blueprint $table) {
            $table->dropColumn(['items', 'total_price']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('budget_limit');
        });
    }
};
