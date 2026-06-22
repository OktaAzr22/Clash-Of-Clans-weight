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
            $table->enum('label', [
                'stay',
                'perlu up',
                'belum ada'
            ])->default('belum ada')->after('champion');
        });
    }

    public function down(): void
    {
        Schema::table('clashers', function (Blueprint $table) {
            $table->dropColumn('label');
        });
    }
};
