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
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE penduduks ALTER COLUMN jenis_kelamin DROP NOT NULL');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE penduduks ALTER COLUMN tanggal_lahir DROP NOT NULL');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE penduduks ALTER COLUMN rt_rw DROP NOT NULL');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE penduduks ALTER COLUMN nomor_kk DROP NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting not null constraints is risky if data exists
    }
};
