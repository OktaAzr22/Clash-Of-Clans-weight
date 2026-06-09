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
        Schema::create('war_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('war_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('town_hall');

            $table->unsignedInteger('clan_a_count');

            $table->unsignedInteger('clan_b_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('war_details');
    }
};
