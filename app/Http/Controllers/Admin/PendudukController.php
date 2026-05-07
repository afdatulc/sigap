<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function index()
    {
        $penduduk = Penduduk::latest()->paginate(10);
        return view('admin.penduduk.index', compact('penduduk'));
    }

    public function create()
    {
        return view('admin.penduduk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|unique:penduduks,nik|max:16',
            'nama_lengkap' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status_listrik' => 'required|in:Memiliki,Belum Memiliki',
            'status_ekonomi' => 'required|in:Mampu,Menengah,Kurang Mampu',
        ]);

        $validated['created_by'] = auth()->id() ?? 1;

        Penduduk::create($validated);

        return redirect()->route('admin.penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function edit(Penduduk $penduduk)
    {
        return view('admin.penduduk.edit', compact('penduduk'));
    }

    public function update(Request $request, Penduduk $penduduk)
    {
        $validated = $request->validate([
            'nik' => 'required|max:16|unique:penduduks,nik,'.$penduduk->id,
            'nama_lengkap' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status_listrik' => 'required|in:Memiliki,Belum Memiliki',
            'status_ekonomi' => 'required|in:Mampu,Menengah,Kurang Mampu',
        ]);

        $penduduk->update($validated);

        return redirect()->route('admin.penduduk.index')->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();
        return redirect()->route('admin.penduduk.index')->with('success', 'Data penduduk berhasil dihapus.');
    }
}
