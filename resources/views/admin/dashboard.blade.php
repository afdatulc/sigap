@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Overview Statistik</h2>
            <p class="text-sm text-gray-500 mt-1">Ringkasan data rumah tangga dan status infrastruktur desa saat ini.</p>
        </div>
        <div class="flex gap-2">
            <button class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors shadow-sm">
                Unduh Laporan
            </button>
            <a href="{{ route('admin.rumah.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors shadow-sm shadow-emerald-200">
                Tambah Data Rumah
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card Total Rumah -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between hover:shadow-md transition-shadow duration-200">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Rumah</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ $totalRumah ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
        </div>

        <!-- Card Total Usaha -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between hover:shadow-md transition-shadow duration-200">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Rumah Berusaha</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ $totalUsaha ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
        </div>

        <!-- Card Listrik (Ada) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between hover:shadow-md transition-shadow duration-200">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Listrik (PLN)</p>
                <h3 class="text-2xl font-bold text-emerald-600">{{ $listrikTersambung ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
        </div>

        <!-- Card Listrik (Belum) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between hover:shadow-md transition-shadow duration-200">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Tanpa Listrik</p>
                <h3 class="text-2xl font-bold text-rose-600">{{ $listrikBelum ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414"/></svg>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart Listrik -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-base font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Distribusi Status Listrik
            </h3>
            <div class="h-64">
                <canvas id="chartListrik"></canvas>
            </div>
        </div>

        <!-- Chart Usaha -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-base font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Proporsi Kepemilikan Usaha
            </h3>
            <div class="h-64">
                <canvas id="chartUsaha"></canvas>
            </div>
        </div>
    </div>

    <!-- Progress Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Map Preview -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Peta Geospasial Desa
                </h2>
                <div class="flex gap-4 items-center">
                    <div class="flex items-center gap-1.5 text-[10px] font-bold text-gray-500 uppercase">
                        <span class="w-2 h-2 rounded-full bg-[#10b981] ring-1 ring-white"></span> OK
                        <span class="w-2 h-2 rounded-full bg-[#ef4444] ring-1 ring-white ml-2"></span> No
                        <span class="w-2 h-2 rounded-full bg-[#8b5cf6] ring-1 ring-white ml-2"></span> UMKM
                    </div>
                </div>
            </div>
            <div class="p-1">
                <div id="mapPreview" class="h-[500px] w-full rounded-b-lg z-0"></div>
            </div>
        </div>

        <!-- Progress Pencacahan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-[560px]">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Progress Pencacahan
                </h2>
            </div>
            <div class="flex-1 overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/30">
                        <tr>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase">Mitra Lapangan</th>
                            <th class="px-4 py-3 text-right text-[10px] font-bold text-gray-400 uppercase">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($mitraProgress as $mitra)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded bg-blue-50 flex items-center justify-center text-blue-600 text-xs font-bold uppercase">
                                        {{ substr($mitra->name, 0, 2) }}
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $mitra->name }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold">
                                    {{ $mitra->rumahs_count }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rumahData = @json($rumahData ?? []);
        
        // Tapin Default
        const defaultLat = -2.9377;
        const defaultLng = 115.1539;

        var map = L.map('mapPreview', { 
            scrollWheelZoom: true,
            layers: [
                L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: 'Esri'
                }),
                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
                    subdomains: 'abcd'
                })
            ]
        }).setView([defaultLat, defaultLng], 12);

        const getTeardropIcon = (color) => {
            return L.divIcon({
                className: 'custom-teardrop-icon',
                html: `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"
                              fill="${color}" 
                              stroke="white" 
                              stroke-width="1.5" 
                              stroke-linejoin="round"/>
                    </svg>`,
                iconSize: [30, 30],
                iconAnchor: [15, 30],
                popupAnchor: [0, -30]
            });
        };

        var markers = L.markerClusterGroup();
        var bounds = L.latLngBounds();
        let hasData = false;

        rumahData.forEach(function(item) {
            var lat = parseFloat(item.latitude);
            var lng = parseFloat(item.longitude);
            if(isNaN(lat) || isNaN(lng)) return;

            // Priority Color: UMKM, then Electricity Status
            let color = '#3b82f6'; // Default Blue
            if (item.memiliki_usaha) {
                color = '#8b5cf6'; // Violet
            } else if (item.status_listrik === 'tidak menggunakan listrik') {
                color = '#ef4444'; // Red
            } else if (item.status_listrik === 'listrik pln dengan meteran' || item.status_listrik === 'listrik pln tanpa meteran') {
                color = '#10b981'; // Emerald
            }

            var marker = L.marker([lat, lng], { icon: getTeardropIcon(color) });
            marker.bindPopup(`
                <div class="p-2">
                    <h4 class="font-bold text-gray-900">${item.nama_kepala_rumah}</h4>
                    <p class="text-xs text-gray-500">${item.alamat}</p>
                    <div class="mt-2 text-[10px] font-bold uppercase">
                        ${item.memiliki_usaha ? '<span class="text-purple-600">● Memiliki Usaha</span><br>' : ''}
                        Status Listrik: ${item.status_listrik}
                    </div>
                </div>
            `);
            markers.addLayer(marker);
            bounds.extend([lat, lng]);
            hasData = true;
        });

        map.addLayer(markers);

        if (hasData) {
            map.fitBounds(bounds, { padding: [30, 30] });
        }

        // --- CHARTS LOGIC ---
        
        // 1. Chart Listrik
        const ctxListrik = document.getElementById('chartListrik').getContext('2d');
        const listrikData = @json($listrikStats);
        
        new Chart(ctxListrik, {
            type: 'doughnut',
            data: {
                labels: listrikData.map(item => item.status_listrik.toUpperCase()),
                datasets: [{
                    data: listrikData.map(item => item.total),
                    backgroundColor: [
                        '#10b981', // emerald-500
                        '#f59e0b', // amber-500
                        '#3b82f6', // blue-500
                        '#ef4444', // rose-500
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 11, weight: '600' }
                        }
                    }
                },
                cutout: '70%'
            }
        });

        // 2. Chart Usaha
        const ctxUsaha = document.getElementById('chartUsaha').getContext('2d');
        const usahaData = @json($usahaStats);
        
        new Chart(ctxUsaha, {
            type: 'pie',
            data: {
                labels: Object.keys(usahaData),
                datasets: [{
                    data: Object.values(usahaData),
                    backgroundColor: [
                        '#8b5cf6', // violet-500
                        '#e2e8f0', // slate-200
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 11, weight: '600' }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush

