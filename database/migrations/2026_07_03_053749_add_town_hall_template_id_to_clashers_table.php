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

            $table->foreignId('town_hall_template_id')
                ->nullable()
                ->after('label')
                ->constrained()
                ->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clashers', function (Blueprint $table) {

            $table->dropForeign([
                'town_hall_template_id'
            ]);

            $table->dropColumn(
                'town_hall_template_id'
            );

        });
    }
};