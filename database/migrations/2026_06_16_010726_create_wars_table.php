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
        Schema::create('wars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clan_id')
            ->constrained()
            ->cascadeOnDelete();

            // Lawan
            $table->string('opponent_tag');
            $table->string('opponent_name');

            // preparation, inWar, warEnded
            $table->string('state');

            // 15 vs 15, 30 vs 30, dst.
            $table->unsignedTinyInteger('team_size');

            // Biasanya 2
            $table->unsignedTinyInteger('attacks_per_member');

            // Skor war
            $table->unsignedSmallInteger('clan_stars')->default(0);
            $table->unsignedSmallInteger('opponent_stars')->default(0);

            // Persentase destruction
            $table->decimal('clan_destruction', 5, 2)->default(0);
            $table->decimal('opponent_destruction', 5, 2)->default(0);

            // Waktu war
            $table->timestamp('preparation_start_time')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wars');
    }
};
