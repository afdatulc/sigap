<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rumah;
use Illuminate\Http\Request;
use App\Traits\LogActivity;


class RumahController extends Controller
{
    use LogActivity;

    public function index()
    {
        $query = Rumah::latest();
        
        // Filter for Mitra: Only their own data
        if (auth()->user()->hasRole('Mitra')) {
            $query->where('created_by', auth()->id());
        }

        $rumahs = $query->paginate(10);
        return view('admin.rumah.index', compact('rumahs'));
    }

    public function create()
    {
        return view('admin.rumah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kepala_rumah' => 'required|string|max:255',
            'alamat' => 'required|string',
            'rt_rw' => 'required|string|max:10',
            'jumlah_kk' => 'required|integer|min:1',
            'status_listrik' => 'required|in:listrik pln tanpa meteran,listrik pln dengan meteran,bukan listrik pln,tidak menggunakan listrik',
            'memiliki_usaha' => 'required|boolean',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status_verifikasi'] = auth()->user()->hasRole('Admin') ? 'verified' : 'pending';

        $rumah = Rumah::create($validated);

        $this->logActivity('Tambah Data Rumah', "Menambahkan data rumah kepala keluarga: {$rumah->nama_kepala_rumah}");

        return redirect()->route('admin.rumah.index')->with('success', 'Data rumah berhasil ditambahkan.');

    }

    public function edit(Rumah $rumah)
    {
        // Restriction for Mitra
        if (auth()->user()->hasRole('Mitra') && $rumah->created_by !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.rumah.edit', compact('rumah'));
    }

    public function update(Request $request, Rumah $rumah)
    {
        // Restriction for Mitra
        if (auth()->user()->hasRole('Mitra') && $rumah->created_by !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'nama_kepala_rumah' => 'required|string|max:255',
            'alamat' => 'required|string',
            'rt_rw' => 'required|string|max:10',
            'jumlah_kk' => 'required|integer|min:1',
            'status_listrik' => 'required|in:listrik pln tanpa meteran,listrik pln dengan meteran,bukan listrik pln,tidak menggunakan listrik',
            'memiliki_usaha' => 'required|boolean',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $rumah->update($validated);

        $this->logActivity('Ubah Data Rumah', "Memperbarui data rumah kepala keluarga: {$rumah->nama_kepala_rumah}");

        return redirect()->route('admin.rumah.index')->with('success', 'Data rumah berhasil diperbarui.');

    }

    public function destroy(Rumah $rumah)
    {
        // Restriction for Mitra
        if (auth()->user()->hasRole('Mitra') && $rumah->created_by !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $namaKepala = $rumah->nama_kepala_rumah;
        $rumah->delete();
        
        $this->logActivity('Hapus Data Rumah', "Menghapus data rumah kepala keluarga: {$namaKepala}");

        return redirect()->route('admin.rumah.index')->with('success', 'Data rumah berhasil dihapus.');

    }
}
