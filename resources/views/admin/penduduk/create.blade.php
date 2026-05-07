@extends('layouts.admin')

@section('title', 'Tambah Data Penduduk')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.penduduk.index') }}" class="p-2 text-gray-500 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Tambah Penduduk Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Masukkan data demografi dan tentukan lokasi rumah di peta.</p>
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

    <form action="{{ route('admin.penduduk.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @csrf
        
        <div class="p-6 sm:p-8 space-y-8">
            <!-- Data Diri -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">Informasi Dasar</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk Kependudukan (NIK)</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" class="w-full py-2 px-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 transition-colors" placeholder="16 Digit NIK" required maxlength="16">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full py-2 px-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 transition-colors" placeholder="Sesuai KTP" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2" class="w-full py-2 px-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 transition-colors" placeholder="Nama jalan, RT/RW, Dusun">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">Status & Kondisi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Listrik Rumah</label>
                        <select name="status_listrik" class="w-full py-2 px-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 transition-colors" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Memiliki" {{ old('status_listrik') == 'Memiliki' ? 'selected' : '' }}>Memiliki Meteran Listrik</option>
                            <option value="Belum Memiliki" {{ old('status_listrik') == 'Belum Memiliki' ? 'selected' : '' }}>Belum Memiliki Listrik</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Ekonomi</label>
                        <select name="status_ekonomi" class="w-full py-2 px-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 transition-colors" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Mampu" {{ old('status_ekonomi') == 'Mampu' ? 'selected' : '' }}>Mampu (Berkecukupan)</option>
                            <option value="Menengah" {{ old('status_ekonomi') == 'Menengah' ? 'selected' : '' }}>Menengah</option>
                            <option value="Kurang Mampu" {{ old('status_ekonomi') == 'Kurang Mampu' ? 'selected' : '' }}>Kurang Mampu (Miskin)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Geotagging -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-2 mb-4">Geotagging Lokasi Rumah</h3>
                <p class="text-sm text-gray-500 mb-3">Geser pin (marker) merah pada peta di bawah ini untuk menentukan titik koordinat lokasi rumah.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Latitude</label>
                        <input type="text" id="latitude" name="latitude" value="{{ old('latitude', '-6.200000') }}" class="w-full py-2 px-3 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Longitude</label>
                        <input type="text" id="longitude" name="longitude" value="{{ old('longitude', '106.816666') }}" class="w-full py-2 px-3 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 cursor-not-allowed" readonly>
                    </div>
                </div>
                
                <div class="rounded-xl overflow-hidden border border-gray-300 shadow-inner">
                    <div id="map" class="h-96 w-full z-0"></div>
                </div>
                <div class="mt-2 text-right">
                    <button type="button" id="btnCurrentLoc" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center gap-1 justify-end ml-auto">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Gunakan Lokasi Saya Saat Ini
                    </button>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.penduduk.index') }}" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg text-sm font-bold hover:bg-emerald-700 transition-colors shadow-sm shadow-emerald-200">
                Simpan Data Penduduk
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        const btnCurrentLoc = document.getElementById('btnCurrentLoc');

        let initialLat = parseFloat(latInput.value) || -6.200000;
        let initialLng = parseFloat(lngInput.value) || 106.816666;

        var map = L.map('map').setView([initialLat, initialLng], 13);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap &copy; CARTO',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        var marker = L.marker([initialLat, initialLng], {
            draggable: true
        }).addTo(map);

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
