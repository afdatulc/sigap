<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survei extends Model
{
    protected $fillable = [
        'user_id',
        'catatan',
        'status',
    ];

    public function surveyable()
    {
        return $this->morphTo();
    }

    public function surveyor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
