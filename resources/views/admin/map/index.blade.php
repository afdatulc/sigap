@extends('layouts.admin')

@section('title', 'Peta Persebaran')

@section('content')
<div class="space-y-8 pb-12">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Peta Persebaran Desa</h2>
            <p class="text-sm text-gray-500 mt-1">Visualisasi geografis titik lokasi rumah tangga dan unit usaha.</p>
        </div>
    </div>

    <!-- Map 1: Direktori Usaha -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Direktori Ekonomi & Usaha
            </h2>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-[#8b5cf6] ring-2 ring-white"></span>
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Unit Usaha / UMKM</span>
            </div>
        </div>
        <div class="p-1">
            <div id="map-usaha" class="h-[500px] w-full rounded-b-xl z-0"></div>
        </div>
    </div>

    <!-- Map 2: Peta Listrik -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Persebaran Kepemilikan Listrik
            </h2>
            <div class="flex flex-wrap gap-4 items-center">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#10b981] ring-2 ring-white"></span>
                    <span class="text-[10px] font-bold text-gray-500 uppercase">PLN Meter</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#f59e0b] ring-2 ring-white"></span>
                    <span class="text-[10px] font-bold text-gray-500 uppercase">PLN Non-Meter</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#3b82f6] ring-2 ring-white"></span>
                    <span class="text-[10px] font-bold text-gray-500 uppercase">Non-PLN</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#ef4444] ring-2 ring-white"></span>
                    <span class="text-[10px] font-bold text-gray-500 uppercase">No Listrik</span>
                </div>
            </div>
        </div>
        <div class="p-1">
            <div id="map-listrik" class="h-[500px] w-full rounded-b-xl z-0"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rumahData = @json($rumahData);

        const defaultLat = -2.9377;
        const defaultLng = 115.1539;
        // Clean Satellite View (No distracting business icons)
        const baseLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EBP, and the GIS User Community'
        });

        const labelsLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        });

        // --- MAP 1: USAHA ---
        var mapUsaha = L.map('map-usaha', { 
            scrollWheelZoom: true,
            layers: [baseLayer, labelsLayer]
        }).setView([defaultLat, defaultLng], 13);

        // --- MAP 2: LISTRIK ---
        var mapListrik = L.map('map-listrik', { 
            scrollWheelZoom: true,
            layers: [
                L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: 'Esri'
                }),
                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
                    subdomains: 'abcd'
                })
            ]
        }).setView([defaultLat, defaultLng], 13);

        const getTeardropIcon = (color) => {
            return L.divIcon({
                className: 'custom-teardrop-icon',
                html: `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" 
                              fill="${color}" 
                              stroke="white" 
                              stroke-width="1.5" 
                              stroke-linejoin="round"/>
                    </svg>`,
                iconSize: [32, 32],
                iconAnchor: [16, 32],
                popupAnchor: [0, -32]
            });
        };

        var markersUsaha = L.markerClusterGroup();
        var markersListrik = L.markerClusterGroup();
        var boundsUsaha = L.latLngBounds();
        var boundsListrik = L.latLngBounds();
        let hasUsaha = false;
        let hasListrik = false;

        rumahData.forEach(function(item) {
            var lat = parseFloat(item.latitude);
            var lng = parseFloat(item.longitude);
            if(isNaN(lat) || isNaN(lng)) return;

            // Map 1: Usaha
            if (item.memiliki_usaha) {
                var mUsaha = L.marker([lat, lng], { icon: getTeardropIcon('#8b5cf6') });
                mUsaha.bindPopup(`
                    <div class="p-3">
                        <h4 class="font-bold text-gray-900 text-sm">${item.nama_kepala_rumah}</h4>
                        <p class="text-[10px] text-gray-500">${item.alamat}</p>
                        <div class="mt-2 text-[10px] font-bold text-purple-600 uppercase">● Memiliki Usaha/UMKM</div>
                    </div>
                `);
                markersUsaha.addLayer(mUsaha);
                boundsUsaha.extend([lat, lng]);
                hasUsaha = true;
            }

            // Map 2: Listrik
            let lColor = '';
            if (item.status_listrik === 'listrik pln dengan meteran') lColor = '#10b981';
            else if (item.status_listrik === 'listrik pln tanpa meteran') lColor = '#f59e0b';
            else if (item.status_listrik === 'bukan listrik pln') lColor = '#3b82f6';
            else lColor = '#ef4444';

            var mListrik = L.marker([lat, lng], { icon: getTeardropIcon(lColor) });
            mListrik.bindPopup(`
                <div class="p-3">
                    <h4 class="font-bold text-gray-900 text-sm">${item.nama_kepala_rumah}</h4>
                    <div class="mt-1 text-[10px] font-bold text-gray-500 uppercase">Listrik: ${item.status_listrik}</div>
                </div>
            `);
            markersListrik.addLayer(mListrik);
            boundsListrik.extend([lat, lng]);
            hasListrik = true;
        });

        mapUsaha.addLayer(markersUsaha);
        mapListrik.addLayer(markersListrik);

        if (hasUsaha) mapUsaha.fitBounds(boundsUsaha, { padding: [50, 50] });
        if (hasListrik) mapListrik.fitBounds(boundsListrik, { padding: [50, 50] });

    });
</script>
@endpush
