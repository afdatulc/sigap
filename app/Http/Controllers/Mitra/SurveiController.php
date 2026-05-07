<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Survei;
use App\Models\Penduduk;
use App\Models\Usaha;
use Illuminate\Http\Request;

class SurveiController extends Controller
{
    public function index()
    {
        // View all surveis submitted by this Mitra
        $surveis = Survei::where('user_id', auth()->id())->latest()->paginate(10);
        return view('mitra.survei.index', compact('surveis'));
    }

    public function createPenduduk()
    {
        return view('mitra.survei.create_penduduk');
    }

    public function storePenduduk(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|unique:penduduks,nik|max:16',
            'nama_lengkap' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status_listrik' => 'required|in:Memiliki,Belum Memiliki',
            'status_ekonomi' => 'required|in:Mampu,Menengah,Kurang Mampu',
            'catatan' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status_verifikasi'] = 'pending'; // Requires admin verification

        $penduduk = Penduduk::create($validated);

        // Create log in Survei table
        $penduduk->surveis()->create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('mitra.survei.index')->with('success', 'Data Survei Penduduk berhasil disubmit dan menunggu verifikasi.');
    }

    public function createUsaha()
    {
        return view('mitra.survei.create_usaha');
    }

    public function storeUsaha(Request $request)
    {
        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'pemilik_usaha' => 'required|string|max:100',
            'kategori_usaha' => 'required|string|max:100',
            'deskripsi_usaha' => 'nullable|string',
            'alamat_usaha' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'nomor_telepon' => 'nullable|string|max:20',
            'status_aktif' => 'boolean',
            'catatan' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status_verifikasi'] = 'pending'; // Requires admin verification
        
        if (!$request->has('status_aktif')) {
            $validated['status_aktif'] = false;
        }

        $usaha = Usaha::create($validated);

        // Create log in Survei table
        $usaha->surveis()->create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('mitra.survei.index')->with('success', 'Data Survei Usaha berhasil disubmit dan menunggu verifikasi.');
    }
}
