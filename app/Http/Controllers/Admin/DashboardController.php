<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Penduduk;
use App\Models\Usaha;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPenduduk = Penduduk::count();
        $totalUsaha = Usaha::count();
        $listrikTersambung = Penduduk::where('status_listrik', 'Memiliki')->count();
        $listrikBelum = Penduduk::where('status_listrik', 'Belum Memiliki')->count();

        return view('admin.dashboard', compact(
            'totalPenduduk', 
            'totalUsaha', 
            'listrikTersambung', 
            'listrikBelum'
        ));
    }
}
