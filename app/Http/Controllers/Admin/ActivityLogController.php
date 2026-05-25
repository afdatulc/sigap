<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the activity logs.
     */
    public function index()
    {
        $logs = LogAktivitas::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.activity-log.index', compact('logs'));
    }
}
