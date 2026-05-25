<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rumah;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        // Fetch data with valid coordinates only
        $rumahData = Rumah::whereNotNull('latitude')
                                ->whereNotNull('longitude')
                                ->get();

        return view('admin.map.index', compact('rumahData'));
    }
}
