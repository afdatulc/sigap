<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usaha;
use Illuminate\Http\Request;

class UsahaController extends Controller
{
    public function index()
    {
        $usaha = Usaha::latest()->paginate(10);
        return view('admin.usaha.index', compact('usaha'));
    }

    public function create()
    {
        return view('admin.usaha.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'pemilik_usaha' => 'required|string|max:100',
            'kategori_usaha' => 'required|string|max:100',
            'deskripsi_usaha' => 'nullable|string',
            'alamat_usaha' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'nomor_telepon' => 'nullable|string|max:20',
            'status_aktif' => 'boolean',
        ]);

        $validated['created_by'] = auth()->id() ?? 1;
        // Default verified status
        $validated['status_verifikasi'] = 'verified';

        Usaha::create($validated);

        return redirect()->route('admin.usaha.index')->with('success', 'Data usaha berhasil ditambahkan.');
    }

    public function edit(Usaha $usaha)
    {
        return view('admin.usaha.edit', compact('usaha'));
    }

    public function update(Request $request, Usaha $usaha)
    {
        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'pemilik_usaha' => 'required|string|max:100',
            'kategori_usaha' => 'required|string|max:100',
            'deskripsi_usaha' => 'nullable|string',
            'alamat_usaha' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'nomor_telepon' => 'nullable|string|max:20',
            'status_aktif' => 'boolean',
        ]);

        if (!$request->has('status_aktif')) {
            $validated['status_aktif'] = false;
        }

        $usaha->update($validated);

        return redirect()->route('admin.usaha.index')->with('success', 'Data usaha berhasil diperbarui.');
    }

    public function destroy(Usaha $usaha)
    {
        $usaha->delete();
        return redirect()->route('admin.usaha.index')->with('success', 'Data usaha berhasil dihapus.');
    }
}
