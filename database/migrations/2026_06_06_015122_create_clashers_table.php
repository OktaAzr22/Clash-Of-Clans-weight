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

            $table->unsignedTinyInteger('town_hall');

            $table->unsignedSmallInteger('king')->default(0);
            $table->unsignedSmallInteger('queen')->default(0);
            $table->unsignedSmallInteger('warden')->default(0);
            $table->unsignedSmallInteger('champion')->default(0);

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
