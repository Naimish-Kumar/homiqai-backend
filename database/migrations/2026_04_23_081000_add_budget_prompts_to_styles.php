<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('styles', function (Blueprint $row) {
            $row->text('prompt_low')->nullable()->after('prompt_prefix');
            $row->text('prompt_medium')->nullable()->after('prompt_low');
            $row->text('prompt_high')->nullable()->after('prompt_medium');
        });
    }

    public function down(): void
    {
        Schema::table('styles', function (Blueprint $row) {
            $row->dropColumn(['prompt_low', 'prompt_medium', 'prompt_high']);
        });
    }
};
