<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usaha extends Model
{
    protected $fillable = [
        'nama_usaha',
        'pemilik_usaha',
        'kategori_usaha',
        'deskripsi_usaha',
        'alamat_usaha',
        'latitude',
        'longitude',
        'nomor_telepon',
        'status_aktif',
        'status_verifikasi',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function surveis()
    {
        return $this->morphMany(Survei::class, 'surveyable');
    }
}
