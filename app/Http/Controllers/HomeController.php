<?php

namespace App\Http\Controllers;

use App\Models\Rumah;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $isAdmin = auth()->check() && auth()->user()->hasRole('Admin');

        $stats = [
            'rumah' => Rumah::count(),
            'usaha' => Rumah::where('memiliki_usaha', true)->count(),
            'listrik' => Rumah::whereIn('status_listrik', ['listrik pln dengan meteran', 'listrik pln tanpa meteran'])->count(),
        ];

        // Chart Data: Distribusi Listrik
        $listrikStats = Rumah::selectRaw('status_listrik, count(*) as total')
            ->groupBy('status_listrik')
            ->get();

        // Chart Data: Kepemilikan Usaha
        $usahaStats = [
            'Memiliki Usaha' => Rumah::where('memiliki_usaha', true)->count(),
            'Tidak Memiliki Usaha' => Rumah::where('memiliki_usaha', false)->count(),
        ];

        // RT/RW List for Filter
        $rtRwList = Rumah::whereNotNull('rt_rw')
            ->distinct()
            ->orderBy('rt_rw')
            ->pluck('rt_rw');

        // Fetch data for public map with Privacy Logic
        $query = Rumah::whereNotNull('latitude')->whereNotNull('longitude');
        
        $columns = ['id', 'status_listrik', 'memiliki_usaha', 'latitude', 'longitude', 'rt_rw'];
        if ($isAdmin) {
            $columns[] = 'nama_kepala_rumah';
            $columns[] = 'alamat';
        }

        $rumahData = $query->get($columns)->map(function($item) use ($isAdmin) {
            if (!$isAdmin) {
                $item->nama_kepala_rumah = 'Warga Desa'; // Anonymized
                $item->alamat = 'Alamat Disembunyikan'; // Anonymized
            }
            return $item;
        });

        // Usaha Directory for Public
        $usahaDirectory = Rumah::where('memiliki_usaha', true)
            ->get(['id', 'nama_kepala_rumah', 'alamat', 'rt_rw']);
                                
        return view('welcome', compact('stats', 'rumahData', 'listrikStats', 'usahaStats', 'rtRwList', 'usahaDirectory', 'isAdmin'));
    }
}
