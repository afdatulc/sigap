<?php

namespace App\Traits;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogActivity
{
    /**
     * Log a user activity
     *
     * @param string $aktivitas
     * @param string|null $detail
     * @return void
     */
    public function logActivity($aktivitas, $detail = null)
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => $aktivitas,
            'detail' => $detail,
            'ip_address' => Request::ip(),
        ]);
    }
}
