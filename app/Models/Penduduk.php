<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    protected $fillable = [
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'rt_rw',
        'nomor_kk',
        'status_listrik',
        'daya_listrik',
        'latitude',
        'longitude',
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
