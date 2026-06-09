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
            $table->string('source_clan_name');

            $table->string('clan_a_name');

            $table->string('clan_b_name');

            $table->unsignedInteger('war_size');

            $table->enum('winner', [
                'clan_a',
                'clan_b',
                'draw'
            ])->nullable();
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
