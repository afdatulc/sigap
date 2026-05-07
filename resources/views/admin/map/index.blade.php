@extends('layouts.admin')

@section('title', 'Peta Persebaran')

@section('content')
<div class="h-[calc(100vh-10rem)] min-h-[500px] flex flex-col space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 shrink-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Peta Persebaran Desa</h2>
            <p class="text-sm text-gray-500 mt-1">Visualisasi geografis titik lokasi rumah penduduk dan entitas usaha.</p>
        </div>
        <div class="flex gap-3 bg-white p-2 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center gap-2 px-2">
                <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                <span class="text-xs font-medium text-gray-700">Rumah Penduduk ({{ count($pendudukData) }})</span>
            </div>
            <div class="w-px bg-gray-200"></div>
            <div class="flex items-center gap-2 px-2">
                <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                <span class="text-xs font-medium text-gray-700">Lokasi Usaha ({{ count($usahaData) }})</span>
            </div>
        </div>
    </div>

    <!-- Map Container -->
    <div class="flex-1 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden relative">
        <div id="main-map" class="absolute inset-0 w-full h-full z-0"></div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    /* Custom Map Styles */
    .leaflet-popup-content-wrapper {
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .leaflet-popup-content {
        margin: 0;
        min-width: 200px;
    }
    
    /* Marker colors via CSS filter */
    .marker-penduduk { filter: hue-rotate(0deg); } /* Default blue */
    .marker-usaha { filter: hue-rotate(150deg); } /* Pink/Red-ish */
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Parse data passed from controller
        const pendudukData = @json($pendudukData);
        const usahaData = @json($usahaData);

        // Determine center point (fallback to general coordinates if empty)
        let centerLat = -6.200000;
        let centerLng = 106.816666;
        
        if (pendudukData.length > 0) {
            centerLat = parseFloat(pendudukData[0].latitude);
            centerLng = parseFloat(pendudukData[0].longitude);
        } else if (usahaData.length > 0) {
            centerLat = parseFloat(usahaData[0].latitude);
            centerLng = parseFloat(usahaData[0].longitude);
        }

        // Initialize Map
        var map = L.map('main-map').setView([centerLat, centerLng], 14);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap &copy; CARTO',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        // Layer Groups for filtering (optional feature for later)
        var pendudukLayer = L.layerGroup().addTo(map);
        var usahaLayer = L.layerGroup().addTo(map);

        // Map Bounds to auto-zoom to fit all markers
        var bounds = L.latLngBounds();
        let hasMarkers = false;

        // Render Penduduk Markers
        pendudukData.forEach(function(item) {
            var lat = parseFloat(item.latitude);
            var lng = parseFloat(item.longitude);
            if(isNaN(lat) || isNaN(lng)) return;

            var marker = L.marker([lat, lng]);
            marker._icon && marker._icon.classList.add("marker-penduduk");

            var popupContent = `
                <div class="p-3">
                    <div class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Penduduk</div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">${item.nama_lengkap}</h4>
                    <p class="text-xs text-gray-600 mb-2">${item.alamat || 'Alamat tidak tersedia'}</p>
                    <div class="flex gap-1 flex-wrap">
                        <span class="px-2 py-0.5 bg-gray-100 rounded-md text-[10px] font-medium text-gray-600">Listrik: ${item.status_listrik}</span>
                        <span class="px-2 py-0.5 bg-gray-100 rounded-md text-[10px] font-medium text-gray-600">Eko: ${item.status_ekonomi}</span>
                    </div>
                </div>
            `;
            marker.bindPopup(popupContent);
            marker.addTo(pendudukLayer);
            bounds.extend([lat, lng]);
            hasMarkers = true;
        });

        // Render Usaha Markers
        usahaData.forEach(function(item) {
            var lat = parseFloat(item.latitude);
            var lng = parseFloat(item.longitude);
            if(isNaN(lat) || isNaN(lng)) return;

            var marker = L.marker([lat, lng]);
            // Workaround to apply class to marker before it is added to map sometimes requires custom icon, 
            // but for standard marker we can use a small delay or bind on 'add' event
            marker.on('add', function(){
                if(marker._icon) marker._icon.classList.add("marker-usaha");
            });

            let statusBadge = item.status_aktif 
                ? `<span class="text-[10px] font-bold text-emerald-600">Buka/Aktif</span>` 
                : `<span class="text-[10px] font-bold text-rose-600">Tutup</span>`;

            var popupContent = `
                <div class="p-3">
                    <div class="flex justify-between items-center mb-1">
                        <div class="text-xs font-bold text-rose-600 uppercase tracking-wider">Usaha / UMKM</div>
                        ${statusBadge}
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">${item.nama_usaha}</h4>
                    <p class="text-xs text-gray-600 mb-2">Pemilik: ${item.pemilik_usaha}</p>
                    <div class="inline-block px-2 py-0.5 bg-rose-50 border border-rose-100 rounded-md text-[10px] font-medium text-rose-700">
                        Kategori: ${item.kategori_usaha}
                    </div>
                </div>
            `;
            marker.bindPopup(popupContent);
            marker.addTo(usahaLayer);
            bounds.extend([lat, lng]);
            hasMarkers = true;
        });

        // Fit map to bounds if markers exist
        if (hasMarkers) {
            map.fitBounds(bounds, { padding: [50, 50] });
        }

        // Add Layer Control
        var overlayMaps = {
            "Rumah Penduduk": pendudukLayer,
            "Lokasi Usaha": usahaLayer
        };
        L.control.layers(null, overlayMaps, {position: 'topright'}).addTo(map);
    });
</script>
@endpush
