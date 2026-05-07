@extends('layouts.admin')

@section('title', 'Edit Data Usaha')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.usaha.index') }}" class="p-2 text-gray-500 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Data Usaha</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi dan lokasi untuk {{ $usaha->nama_usaha }}.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 text-rose-800 border-l-4 border-rose-500 p-4 rounded-r-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-rose-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium">Ada kesalahan pada isian Anda:</h3>
                    <ul class="mt-1 text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.usaha.update', $usaha->id) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @csrf
        @method('PUT')
        
        <div class="p-6 sm:p-8 space-y-8">
            <!-- Profil Usaha -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">Profil Usaha</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Usaha / Toko</label>
                        <input type="text" name="nama_usaha" value="{{ old('nama_usaha', $usaha->nama_usaha) }}" class="w-full py-2 px-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 transition-colors" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik</label>
                        <input type="text" name="pemilik_usaha" value="{{ old('pemilik_usaha', $usaha->pemilik_usaha) }}" class="w-full py-2 px-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 transition-colors" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Usaha</label>
                        <select name="kategori_usaha" class="w-full py-2 px-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 transition-colors" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Perdagangan" {{ old('kategori_usaha', $usaha->kategori_usaha) == 'Perdagangan' ? 'selected' : '' }}>Perdagangan (Toko, Warung)</option>
                            <option value="Pertanian" {{ old('kategori_usaha', $usaha->kategori_usaha) == 'Pertanian' ? 'selected' : '' }}>Pertanian & Perkebunan</option>
                            <option value="Peternakan" {{ old('kategori_usaha', $usaha->kategori_usaha) == 'Peternakan' ? 'selected' : '' }}>Peternakan</option>
                            <option value="Jasa" {{ old('kategori_usaha', $usaha->kategori_usaha) == 'Jasa' ? 'selected' : '' }}>Jasa (Bengkel, Salon, dll)</option>
                            <option value="Industri Kecil" {{ old('kategori_usaha', $usaha->kategori_usaha) == 'Industri Kecil' ? 'selected' : '' }}>Industri Kecil / Kerajinan</option>
                            <option value="Lainnya" {{ old('kategori_usaha', $usaha->kategori_usaha) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon/HP (Opsional)</label>
                        <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $usaha->nomor_telepon) }}" class="w-full py-2 px-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 transition-colors">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat Usaha</label>
                        <textarea name="deskripsi_usaha" rows="2" class="w-full py-2 px-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 transition-colors">{{ old('deskripsi_usaha', $usaha->deskripsi_usaha) }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Tempat Usaha</label>
                        <textarea name="alamat_usaha" rows="2" class="w-full py-2 px-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 transition-colors" required>{{ old('alamat_usaha', $usaha->alamat_usaha) }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="flex items-center gap-3 p-4 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer">
                            <input type="checkbox" name="status_aktif" value="1" {{ old('status_aktif', $usaha->status_aktif) ? 'checked' : '' }} class="w-5 h-5 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500">
                            <div>
                                <span class="block text-sm font-medium text-gray-900">Usaha Masih Aktif/Beroperasi</span>
                                <span class="block text-xs text-gray-500">Hapus centang jika usaha sudah tutup atau tidak beroperasi lagi.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Geotagging -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">Geotagging Lokasi Usaha</h3>
                <p class="text-sm text-gray-500 mb-3">Geser pin (marker) biru pada peta di bawah ini untuk menentukan titik koordinat tempat usaha.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Latitude</label>
                        <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $usaha->latitude ?? '-6.200000') }}" class="w-full py-2 px-3 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Longitude</label>
                        <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $usaha->longitude ?? '106.816666') }}" class="w-full py-2 px-3 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 cursor-not-allowed" readonly>
                    </div>
                </div>
                
                <div class="rounded-xl overflow-hidden border border-gray-300 shadow-inner">
                    <div id="map" class="h-96 w-full z-0"></div>
                </div>
                <div class="mt-2 text-right">
                    <button type="button" id="btnCurrentLoc" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium flex items-center gap-1 justify-end ml-auto">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Gunakan Lokasi Saya Saat Ini
                    </button>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.usaha.index') }}" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg text-sm font-bold hover:bg-emerald-700 transition-colors shadow-sm shadow-emerald-200">
                Perbarui Data Usaha
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<style>
    /* Custom icon for Usaha marker */
    .usaha-icon {
        filter: hue-rotate(200deg); /* Make standard leaflet marker blue/indigo instead of standard */
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        const btnCurrentLoc = document.getElementById('btnCurrentLoc');

        let initialLat = parseFloat(latInput.value) || -6.200000;
        let initialLng = parseFloat(lngInput.value) || 106.816666;

        var map = L.map('map').setView([initialLat, initialLng], {{ $usaha->latitude ? 16 : 13 }});

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap &copy; CARTO',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        // Standard marker, stylized to blueish
        var marker = L.marker([initialLat, initialLng], {
            draggable: true
        }).addTo(map);
        marker._icon.classList.add("usaha-icon");

        // Update inputs on drag end
        marker.on('dragend', function (e) {
            var position = marker.getLatLng();
            latInput.value = position.lat.toFixed(8);
            lngInput.value = position.lng.toFixed(8);
            map.panTo(position);
        });

        // Update marker on map click
        map.on('click', function(e) {
            var position = e.latlng;
            marker.setLatLng(position);
            latInput.value = position.lat.toFixed(8);
            lngInput.value = position.lng.toFixed(8);
            map.panTo(position);
        });

        // HTML5 Geolocation
        btnCurrentLoc.addEventListener('click', function() {
            if (navigator.geolocation) {
                btnCurrentLoc.innerHTML = 'Mencari lokasi...';
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    
                    var newLatLng = new L.LatLng(lat, lng);
                    marker.setLatLng(newLatLng);
                    map.setView(newLatLng, 16);
                    
                    latInput.value = lat.toFixed(8);
                    lngInput.value = lng.toFixed(8);
                    
                    btnCurrentLoc.innerHTML = 'Lokasi ditemukan!';
                    setTimeout(() => {
                        btnCurrentLoc.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Gunakan Lokasi Saya Saat Ini';
                    }, 3000);
                }, function(error) {
                    alert('Gagal mendapatkan lokasi. Pastikan izin lokasi aktif di browser Anda.');
                    btnCurrentLoc.innerHTML = 'Gunakan Lokasi Saya Saat Ini';
                });
            } else {
                alert("Geolokasi tidak didukung oleh browser ini.");
            }
        });
    });
</script>
@endpush
