<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGAP Desa - Sistem Informasi Geospasial & Pendataan Desa</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-heading { font-family: 'Outfit', sans-serif; }
        .hero-pattern {
            background-color: #ffffff;
            background-image: radial-gradient(rgba(16, 185, 129, 0.1) 2px, transparent 2px), radial-gradient(rgba(16, 185, 129, 0.1) 2px, transparent 2px);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .leaflet-popup-content-wrapper {
            border-radius: 0.75rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0,0,0,0.05);
        }
        .marker-penduduk { filter: hue-rotate(0deg); }
        .marker-usaha { filter: hue-rotate(150deg); }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-800 selection:bg-emerald-200 selection:text-emerald-900">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300" id="navbar" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)" :class="{ 'glass-panel shadow-sm': scrolled, 'bg-transparent py-2': !scrolled }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 text-white">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M21.53 7.15a1 1 0 00-1.06-.15l-4.5 2-4.5-2a1 1 0 00-.94 0l-4.5 2-4.5-2A1 1 0 000 8v11a1 1 0 00.53.88l5 2.5a1 1 0 00.94 0l4.5-2 4.5 2a1 1 0 00.94 0l5-2.5A1 1 0 0022 19V8a1 1 0 00-.47-.85zM11 18.28l-4-1.78v-7.5l4 1.78v7.5zm1-8.56l4-1.78v7.5l-4 1.78v-7.5zM6 8.35L10.32 10.27 6 12.19 1.68 10.27 6 8.35z"/></svg>
                    </div>
                    <span class="font-heading font-bold text-2xl tracking-tight text-slate-900">SIGAP<span class="text-emerald-600">Desa</span></span>
                </div>
                
                <div class="hidden md:flex items-center gap-8 font-medium">
                    <a href="#beranda" class="text-slate-600 hover:text-emerald-600 transition-colors">Beranda</a>
                    <a href="#statistik" class="text-slate-600 hover:text-emerald-600 transition-colors">Statistik</a>
                    <a href="#peta" class="text-slate-600 hover:text-emerald-600 transition-colors">Peta Potensi</a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/admin/dashboard') }}" class="px-5 py-2.5 rounded-full bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition-all shadow-md hover:shadow-lg focus:ring-4 focus:ring-slate-200">Ke Dashboard</a>
                    @else
                        <a href="{{ url('/dev/login-admin') }}" class="px-5 py-2.5 rounded-full bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition-all shadow-md shadow-emerald-600/20 hover:shadow-lg hover:shadow-emerald-600/40 focus:ring-4 focus:ring-emerald-100 flex items-center gap-2">
                            <span>Login Portal</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-pattern">
        <!-- Abstract glowing blobs -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[500px] h-[500px] bg-emerald-300/30 rounded-full blur-3xl opacity-50 mix-blend-multiply pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[400px] h-[400px] bg-teal-300/30 rounded-full blur-3xl opacity-50 mix-blend-multiply pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-semibold mb-6 shadow-sm">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    Program Desa Cantik (Desa Cinta Statistik)
                </div>
                <h1 class="font-heading text-5xl lg:text-7xl font-extrabold text-slate-900 tracking-tight leading-[1.1] mb-6">
                    Sistem Informasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-600">Geospasial</span> & Pendataan
                </h1>
                <p class="text-lg lg:text-xl text-slate-600 mb-10 leading-relaxed max-w-2xl mx-auto">
                    Mewujudkan transparansi dan kemudahan akses data desa melalui pemetaan digital cerdas. Mendorong potensi ekonomi dan kesejahteraan warga melalui data yang presisi.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#peta" class="px-8 py-4 rounded-full bg-slate-900 text-white font-semibold hover:bg-slate-800 transition-all shadow-xl hover:-translate-y-1">Lihat Peta Desa</a>
                    <a href="#statistik" class="px-8 py-4 rounded-full bg-white text-slate-700 font-semibold border border-slate-200 hover:bg-slate-50 transition-all shadow-sm hover:shadow">Lihat Data Statistik</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section id="statistik" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-heading text-3xl md:text-4xl font-bold text-slate-900 mb-4">Statistik Terkini Desa</h2>
                <p class="text-slate-500 max-w-2xl mx-auto">Data dihimpun langsung oleh tim surveyor kami di lapangan secara real-time untuk memastikan tingkat keakuratan yang tinggi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Stat Card 1 -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:border-emerald-200 transition-colors group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-bl-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                    <div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center text-emerald-600 mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h3 class="text-slate-500 font-medium mb-1">Total Penduduk Terdata</h3>
                    <div class="font-heading text-5xl font-extrabold text-slate-900">{{ number_format($stats['penduduk']) }}</div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:border-teal-200 transition-colors group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-teal-500/10 rounded-bl-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                    <div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center text-teal-600 mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="text-slate-500 font-medium mb-1">Total Potensi UMKM</h3>
                    <div class="font-heading text-5xl font-extrabold text-slate-900">{{ number_format($stats['usaha']) }}</div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:border-amber-200 transition-colors group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-bl-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                    <div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center text-amber-500 mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-slate-500 font-medium mb-1">Rumah Berlistrik</h3>
                    <div class="font-heading text-5xl font-extrabold text-slate-900">{{ number_format($stats['listrik']) }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Map Section -->
    <section id="peta" class="py-24 bg-slate-900 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-10 gap-6">
                <div class="max-w-2xl">
                    <h2 class="font-heading text-3xl md:text-4xl font-bold text-white mb-4">Peta Potensi Geografis</h2>
                    <p class="text-slate-400">Peta publik yang menyajikan sebaran demografi dan titik lokasi ekonomi kreatif warga. Data sensitif telah diamankan.</p>
                </div>
                <div class="flex gap-4 shrink-0">
                    <div class="flex items-center gap-2 bg-slate-800/50 px-4 py-2 rounded-lg border border-slate-700">
                        <span class="w-3 h-3 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.8)]"></span>
                        <span class="text-sm font-medium text-slate-300">Rumah Warga</span>
                    </div>
                    <div class="flex items-center gap-2 bg-slate-800/50 px-4 py-2 rounded-lg border border-slate-700">
                        <span class="w-3 h-3 rounded-full bg-rose-500 shadow-[0_0_10px_rgba(244,63,94,0.8)]"></span>
                        <span class="text-sm font-medium text-slate-300">Lokasi UMKM</span>
                    </div>
                </div>
            </div>

            <!-- Map Wrapper -->
            <div class="rounded-3xl overflow-hidden border border-slate-700 shadow-2xl relative bg-slate-800">
                <div id="public-map" class="h-[600px] w-full z-0"></div>
                
                <!-- Map Overlay Gradient for aesthetics -->
                <div class="absolute inset-0 pointer-events-none shadow-[inset_0_0_100px_rgba(15,23,42,0.8)] z-10"></div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-12 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-600" viewBox="0 0 24 24" fill="currentColor"><path d="M21.53 7.15a1 1 0 00-1.06-.15l-4.5 2-4.5-2a1 1 0 00-.94 0l-4.5 2-4.5-2A1 1 0 000 8v11a1 1 0 00.53.88l5 2.5a1 1 0 00.94 0l4.5-2 4.5 2a1 1 0 00.94 0l5-2.5A1 1 0 0022 19V8a1 1 0 00-.47-.85zM11 18.28l-4-1.78v-7.5l4 1.78v7.5zm1-8.56l4-1.78v7.5l-4 1.78v-7.5zM6 8.35L10.32 10.27 6 12.19 1.68 10.27 6 8.35z"/></svg>
                <span class="font-heading font-bold text-xl text-slate-900">SIGAP<span class="text-emerald-600">Desa</span></span>
            </div>
            <p class="text-slate-500 text-sm">© {{ date('Y') }} Program Desa Cantik. Dikembangkan menggunakan Laravel & Leaflet.</p>
        </div>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pendudukData = @json($pendudukData);
            const usahaData = @json($usahaData);

            let centerLat = -6.200000;
            let centerLng = 106.816666;
            
            if (pendudukData.length > 0) {
                centerLat = parseFloat(pendudukData[0].latitude);
                centerLng = parseFloat(pendudukData[0].longitude);
            } else if (usahaData.length > 0) {
                centerLat = parseFloat(usahaData[0].latitude);
                centerLng = parseFloat(usahaData[0].longitude);
            }

            // Public Map uses dark theme tiles for premium look
            var map = L.map('public-map', { scrollWheelZoom: false }).setView([centerLat, centerLng], 14);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap &copy; CARTO',
                subdomains: 'abcd',
                maxZoom: 20
            }).addTo(map);

            var bounds = L.latLngBounds();
            let hasMarkers = false;

            // Render Penduduk (No NIK, No detailed address)
            pendudukData.forEach(function(item) {
                var lat = parseFloat(item.latitude);
                var lng = parseFloat(item.longitude);
                if(isNaN(lat) || isNaN(lng)) return;

                var marker = L.marker([lat, lng]);
                marker._icon && marker._icon.classList.add("marker-penduduk");

                // Public Safe Popup
                var popupContent = `
                    <div class="px-1 py-2">
                        <div class="text-[10px] font-bold text-blue-600 uppercase tracking-wider mb-1">Data Warga</div>
                        <h4 class="font-bold text-slate-900 text-sm mb-2">${item.nama_lengkap}</h4>
                        <div class="flex gap-1 flex-wrap">
                            <span class="px-2 py-1 bg-slate-100 rounded text-[10px] font-medium text-slate-600">Listrik: ${item.status_listrik}</span>
                        </div>
                    </div>
                `;
                marker.bindPopup(popupContent);
                marker.addTo(map);
                bounds.extend([lat, lng]);
                hasMarkers = true;
            });

            // Render Usaha
            usahaData.forEach(function(item) {
                var lat = parseFloat(item.latitude);
                var lng = parseFloat(item.longitude);
                if(isNaN(lat) || isNaN(lng)) return;

                var marker = L.marker([lat, lng]);
                marker.on('add', function(){
                    if(marker._icon) marker._icon.classList.add("marker-usaha");
                });

                var popupContent = `
                    <div class="px-1 py-2">
                        <div class="text-[10px] font-bold text-rose-600 uppercase tracking-wider mb-1">Potensi Desa</div>
                        <h4 class="font-bold text-slate-900 text-sm mb-1">${item.nama_usaha}</h4>
                        <div class="inline-block px-2 py-1 bg-rose-50 rounded text-[10px] font-medium text-rose-700 mt-1">
                            Sektor ${item.kategori_usaha}
                        </div>
                    </div>
                `;
                marker.bindPopup(popupContent);
                marker.addTo(map);
                bounds.extend([lat, lng]);
                hasMarkers = true;
            });

            if (hasMarkers) {
                map.fitBounds(bounds, { padding: [50, 50] });
            }
        });
    </script>
</body>
</html>
