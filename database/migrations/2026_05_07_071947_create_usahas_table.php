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
        Schema::create('usahas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_usaha');
            $table->string('pemilik_usaha');
            $table->string('kategori_usaha');
            $table->text('deskripsi_usaha')->nullable();
            $table->text('alamat_usaha');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->enum('status_verifikasi', ['draft', 'pending', 'verified', 'rejected'])->default('draft');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usahas');
    }
};
