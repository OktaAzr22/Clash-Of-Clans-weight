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
        Schema::create('clashers', function (Blueprint $table) {
            $table->id();

            $table->string('tag')->unique();
            $table->string('name');

            $table->string('clan_name')->nullable();
            $table->string('clan_tag')->nullable();

            $table->unsignedTinyInteger('town_hall');

            $table->unsignedInteger('war_stars')->default(0);
            $table->unsignedInteger('exp_level')->default(0);

            $table->unsignedSmallInteger('king')->default(0);
            $table->unsignedSmallInteger('queen')->default(0);
            $table->unsignedSmallInteger('warden')->default(0);
            $table->unsignedSmallInteger('champion')->default(0);

            $table->enum('label', [
                'stay',
                'perlu up',
                'over',
            ])->nullable()->default(null);

            $table->boolean('is_ready_war')->default(false);

            $table->timestamp('last_war_profile_update')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clashers');
    }
};