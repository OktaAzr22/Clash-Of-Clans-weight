<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('war_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('war_id')
                ->constrained()
                ->cascadeOnDelete();

            // Relasi ke clashers (boleh null jika belum ada)
            $table->foreignId('clasher_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('player_tag');

            $table->string('name');

            $table->unsignedTinyInteger('town_hall');

            // Posisi map (#1, #2, dst.)
            $table->unsignedTinyInteger('map_position');

            // 0, 1, atau 2
            $table->unsignedTinyInteger('attacks_used')->default(0);

            $table->timestamps();

            // Satu pemain hanya boleh sekali dalam satu war
            $table->unique(['war_id', 'player_tag']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('war_members');
    }
};