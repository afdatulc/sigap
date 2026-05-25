<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    protected $fillable = [
        'nama_kepala_rumah',
        'alamat',
        'rt_rw',
        'jumlah_kk',
        'status_listrik',
        'memiliki_usaha',
        'latitude',
        'longitude',
        'status_verifikasi',
        'created_by'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
