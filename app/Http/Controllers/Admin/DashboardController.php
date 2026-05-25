<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Rumah;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRumah = Rumah::count();
        $totalUsaha = Rumah::where('memiliki_usaha', true)->count();
        $listrikTersambung = Rumah::whereIn('status_listrik', ['listrik pln dengan meteran', 'listrik pln tanpa meteran'])->count();
        $listrikBelum = Rumah::where('status_listrik', 'tidak menggunakan listrik')->count();
        
        $rumahData = Rumah::whereNotNull('latitude')->whereNotNull('longitude')->get();

        // Chart Data: Status Listrik
        $listrikStats = Rumah::selectRaw('status_listrik, count(*) as total')
            ->groupBy('status_listrik')
            ->get();
            
        // Chart Data: Kepemilikan Usaha
        $usahaStats = [
            'Memiliki Usaha' => Rumah::where('memiliki_usaha', true)->count(),
            'Tidak Memiliki Usaha' => Rumah::where('memiliki_usaha', false)->count(),
        ];

        // Progress Pencacahan Mitra
        $mitraProgress = User::role('Mitra')->withCount('rumahs')->get();

        return view('admin.dashboard', compact(
            'totalRumah', 
            'totalUsaha', 
            'listrikTersambung', 
            'listrikBelum',
            'rumahData',
            'listrikStats',
            'usahaStats',
            'mitraProgress'
        ));

    }
}
