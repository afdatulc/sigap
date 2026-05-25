<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Rumah;
use Illuminate\Http\Request;

class SurveiController extends Controller
{
    public function index()
    {
        // Summary for Mitra
        $totalInput = Rumah::where('created_by', auth()->id())->count();
        $totalTerpetakan = Rumah::where('created_by', auth()->id())
                                ->whereNotNull('latitude')
                                ->whereNotNull('longitude')
                                ->count();
        $totalBelumTerpetakan = $totalInput - $totalTerpetakan;

        $recentInputs = Rumah::where('created_by', auth()->id())
                             ->latest()
                             ->take(5)
                             ->get();

        return view('mitra.survei.index', compact(
            'totalInput', 
            'totalTerpetakan', 
            'totalBelumTerpetakan',
            'recentInputs'
        ));
    }
}
