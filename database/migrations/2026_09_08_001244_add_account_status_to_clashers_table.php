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
        Schema::table('clashers', function (Blueprint $table) {
            $table->boolean('is_active')
                ->default(true)
                ->after('is_ready_war');

            $table->timestamp('last_active_at')
                ->nullable()
                ->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clashers', function (Blueprint $table) {
            $table->dropColumn([
                'is_active',
                'last_active_at',
            ]);
        });
    }
};
