<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE clashers
            MODIFY COLUMN label
            ENUM(
                'stay',
                'perlu up',
                'over'
            ) NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE clashers
            MODIFY COLUMN label
            ENUM(
                'stay',
                'perlu up',
                'over'
            ) NOT NULL DEFAULT 'perlu up'
        ");
    }
};