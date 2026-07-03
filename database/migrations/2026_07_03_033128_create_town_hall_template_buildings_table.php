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
        Schema::create('town_hall_template_buildings', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('town_hall');

            $table->foreignId('building_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('slot');

            $table->unsignedTinyInteger('level');

            $table->timestamps();

            $table->unique([
                'town_hall',
                'building_id',
                'slot',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('town_hall_template_buildings');
    }
};
