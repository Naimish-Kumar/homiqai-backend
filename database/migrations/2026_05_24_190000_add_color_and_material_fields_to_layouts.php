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
        Schema::table('layouts', function (Blueprint $table) {
            $table->string('wall_color')->nullable()->after('total_price');
            $table->string('floor_color')->nullable()->after('wall_color');
            $table->string('floor_material')->nullable()->after('floor_color');
            $table->string('ceiling_color')->nullable()->after('floor_material');
            $table->json('saved_palettes')->nullable()->after('ceiling_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layouts', function (Blueprint $table) {
            $table->dropColumn([
                'wall_color',
                'floor_color',
                'floor_material',
                'ceiling_color',
                'saved_palettes',
            ]);
        });
    }
};
