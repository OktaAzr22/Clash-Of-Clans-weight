<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clashers');
    }
};