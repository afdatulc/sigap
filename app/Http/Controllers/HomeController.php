<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Usaha;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'penduduk' => Penduduk::count(),
            'usaha' => Usaha::count(),
            'listrik' => Penduduk::where('status_listrik', 'Memiliki')->count(),
        ];

        // Fetch data for public map (Hide NIK and detailed address)
        $pendudukData = Penduduk::whereNotNull('latitude')
                                ->whereNotNull('longitude')
                                ->get(['id', 'nama_lengkap', 'status_listrik', 'status_ekonomi', 'latitude', 'longitude']);
                                
        $usahaData = Usaha::whereNotNull('latitude')
                            ->whereNotNull('longitude')
                            ->where('status_aktif', true)
                            ->get(['id', 'nama_usaha', 'kategori_usaha', 'latitude', 'longitude']);

        return view('welcome', compact('stats', 'pendudukData', 'usahaData'));
    }
}
