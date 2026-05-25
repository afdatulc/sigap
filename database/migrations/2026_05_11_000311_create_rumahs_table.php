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
        Schema::create('rumahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kepala_rumah');
            $table->text('alamat');
            $table->string('rt_rw', 10);
            $table->integer('jumlah_kk')->default(1);
            $table->enum('status_listrik', [
                'listrik pln tanpa meteran', 
                'listrik pln dengan meteran', 
                'bukan listrik pln', 
                'tidak menggunakan listrik'
            ]);
            $table->boolean('memiliki_usaha')->default(false);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
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
        Schema::dropIfExists('rumahs');
    }
};
