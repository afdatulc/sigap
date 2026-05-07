<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\Usaha;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        // Fetch data with valid coordinates only
        $pendudukData = Penduduk::whereNotNull('latitude')
                                ->whereNotNull('longitude')
                                ->get(['id', 'nama_lengkap', 'alamat', 'status_listrik', 'status_ekonomi', 'latitude', 'longitude']);
                                
        $usahaData = Usaha::whereNotNull('latitude')
                            ->whereNotNull('longitude')
                            ->get(['id', 'nama_usaha', 'pemilik_usaha', 'kategori_usaha', 'status_aktif', 'latitude', 'longitude']);

        return view('admin.map.index', compact('pendudukData', 'usahaData'));
    }
}
