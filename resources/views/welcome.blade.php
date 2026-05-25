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
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />


    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-heading { font-family: 'Outfit', sans-serif; }
        .hero-pattern {
            position: relative;
            background-color: #ffffff;
        }
        .hero-pattern::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(16, 185, 129, 0.1) 2px, transparent 2px), radial-gradient(rgba(16, 185, 129, 0.1) 2px, transparent 2px);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
            mask-image: linear-gradient(to bottom, black 70%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, black 70%, transparent 100%);
            pointer-events: none;
            z-index: 0;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .leaflet-popup-content-wrapper {
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0,0,0,0.05);
            padding: 0;
            overflow: hidden;
        }
        .leaflet-popup-content { margin: 0; width: 220px !important; }
        
        .map-card {
            border-radius: 2rem;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* Marker Color Overrides using Filters on default icon if needed, 
           but we'll use SVG markers for exact colors as requested */
        .svg-marker {
            filter: drop-shadow(0 4px 3px rgba(0,0,0,0.3));
            transition: all 0.2s;
        }
        .svg-marker:hover {
            transform: scale(1.1) translateY(-2px);
        }

        /* Navbar Z-index Fix */
        #navbar {
            z-index: 9999;
        }

        /* Tooltip Style */
        .custom-tooltip {
            background: rgba(15, 23, 42, 0.9);
            border: none;
            border-radius: 0.5rem;
            color: white;
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            padding: 4px 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .custom-tooltip:before {
            border-right-color: rgba(15, 23, 42, 0.9);
        }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-800 selection:bg-emerald-200 selection:text-emerald-900">

    <!-- Navigation -->
    <nav class="fixed w-full transition-all duration-300" id="navbar" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)" :class="{ 'glass-panel shadow-sm': scrolled, 'bg-transparent py-2': !scrolled }">
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
                    <a href="#peta-usaha" class="text-slate-600 hover:text-emerald-600 transition-colors">Direktori Usaha</a>
                    <a href="#peta-listrik" class="text-slate-600 hover:text-emerald-600 transition-colors">Peta Listrik</a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        @hasrole('Admin')
                            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 rounded-full bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition-all shadow-md hover:shadow-lg">Dashboard Admin</a>
                        @else
                            <a href="{{ route('mitra.survei.index') }}" class="px-5 py-2.5 rounded-full bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition-all shadow-md hover:shadow-lg">Dashboard Mitra</a>
                        @endhasrole
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ url('/dev/login-mitra') }}" class="px-4 py-2 rounded-full border border-emerald-600 text-emerald-600 text-xs font-bold hover:bg-emerald-50 transition-all">Login Mitra</a>
                            <a href="{{ url('/dev/login-admin') }}" class="px-4 py-2 rounded-full bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 transition-all shadow-md shadow-emerald-600/20">Login Admin</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-pattern">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[500px] h-[500px] bg-emerald-300/30 rounded-full blur-3xl opacity-50 mix-blend-multiply pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[400px] h-[400px] bg-teal-300/30 rounded-full blur-3xl opacity-50 mix-blend-multiply pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-semibold mb-6 shadow-sm">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                Program Desa Cantik (Desa Cinta Statistik)
            </div>
            <h1 class="font-heading text-5xl lg:text-7xl font-extrabold text-slate-900 tracking-tight leading-[1.1] mb-6">
                Visualisasi Data <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-600">Geospasial</span> Desa
            </h1>
            <p class="text-lg lg:text-xl text-slate-600 mb-10 leading-relaxed max-w-2xl mx-auto">
                Pemetaan komprehensif untuk mendukung kemandirian ekonomi dan infrastruktur energi desa secara transparan.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#peta-usaha" class="px-8 py-4 rounded-full bg-slate-900 text-white font-semibold hover:bg-slate-800 transition-all shadow-xl hover:-translate-y-1">Eksplor Direktori Usaha</a>
                <a href="#peta-listrik" class="px-8 py-4 rounded-full bg-white text-slate-700 font-semibold border border-slate-200 hover:bg-slate-50 transition-all shadow-sm hover:shadow">Peta Persebaran Listrik</a>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section id="statistik" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-heading text-4xl font-bold text-slate-900 mb-4">Statistik Data Desa</h2>
                <p class="text-slate-600">Gambaran umum kondisi infrastruktur dan ekonomi warga saat ini.</p>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Stat Card 1 -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:border-emerald-200 transition-all text-center">
                    <h3 class="text-slate-500 font-medium mb-1 uppercase text-xs tracking-widest">Total Rumah</h3>
                    <div class="font-heading text-5xl font-extrabold text-slate-900">{{ number_format($stats['rumah']) }}</div>
                </div>
                <!-- Stat Card 2 -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:border-teal-200 transition-all text-center">
                    <h3 class="text-slate-500 font-medium mb-1 uppercase text-xs tracking-widest">Total UMKM</h3>
                    <div class="font-heading text-5xl font-extrabold text-slate-900">{{ number_format($stats['usaha']) }}</div>
                </div>
                <!-- Stat Card 3 -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:border-amber-200 transition-all text-center">
                    <h3 class="text-slate-500 font-medium mb-1 uppercase text-xs tracking-widest">Akses Listrik PLN</h3>
                    <div class="font-heading text-5xl font-extrabold text-slate-900">{{ number_format($stats['listrik']) }}</div>
                </div>
            </div>

            <!-- Interactive Charts -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-slate-50 rounded-[2.5rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-100/30 rounded-full blur-3xl -mr-32 -mt-32 transition-all group-hover:bg-emerald-200/40"></div>
                    
                    <div class="flex flex-col lg:flex-row items-center gap-12 relative z-10">
                        <!-- Chart Side -->
                        <div class="w-full lg:w-1/2">
                            <h4 class="font-heading text-2xl font-bold text-slate-900 mb-8 flex items-center gap-3">
                                <span class="w-3 h-8 bg-emerald-500 rounded-full"></span>
                                Distribusi Status Listrik
                            </h4>
                            <div class="h-[320px] relative">
                                <canvas id="chartListrik"></canvas>
                                <!-- Center Text Overlay -->
                                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none mt-4">
                                    <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">Total Data</span>
                                    <span class="text-4xl font-extrabold text-slate-900">{{ number_format($stats['rumah']) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Info Side -->
                        <div class="w-full lg:w-1/2 space-y-4">
                            <div class="grid grid-cols-1 gap-4">
                                @php
                                    $colors = [
                                        'listrik pln dengan meteran' => ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-700', 'light' => 'bg-emerald-50'],
                                        'listrik pln tanpa meteran' => ['bg' => 'bg-amber-500', 'text' => 'text-amber-700', 'light' => 'bg-amber-50'],
                                        'bukan listrik pln' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-700', 'light' => 'bg-blue-50'],
                                        'tidak ada listrik' => ['bg' => 'bg-rose-500', 'text' => 'text-rose-700', 'light' => 'bg-rose-50'],
                                    ];
                                @endphp

                                @foreach($listrikStats as $item)
                                    @php 
                                        $style = $colors[$item->status_listrik] ?? ['bg' => 'bg-slate-400', 'text' => 'text-slate-700', 'light' => 'bg-slate-50'];
                                        $percentage = ($stats['rumah'] > 0) ? round(($item->total / $stats['rumah']) * 100, 1) : 0;
                                    @endphp
                                    <div class="flex items-center justify-between p-4 rounded-2xl {{ $style['light'] }} border border-white transition-transform hover:scale-[1.02]">
                                        <div class="flex items-center gap-4">
                                            <div class="w-3 h-3 rounded-full {{ $style['bg'] }}"></div>
                                            <div>
                                                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">{{ $item->status_listrik }}</div>
                                                <div class="text-lg font-extrabold text-slate-900">{{ number_format($item->total) }} <span class="text-sm font-medium text-slate-500 ml-1">Rumah</span></div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-2xl font-black {{ $style['text'] }} opacity-40">{{ $percentage }}%</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map 1: Direktori Usaha -->
    <section id="peta-usaha" class="py-24 bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="font-heading text-4xl font-bold text-white mb-4">Direktori Ekonomi Desa</h2>
                <p class="text-slate-400">Peta lokasi unit usaha dan UMKM milik warga desa</p>
            </div>
            
            <div class="map-card bg-slate-800 relative">
                <div id="map-usaha" class="h-[600px] w-full"></div>
                <div class="absolute bottom-6 right-6 z-[1000] bg-white/90 backdrop-blur px-4 py-3 rounded-2xl shadow-xl border border-white/20">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full bg-[#8b5cf6] ring-2 ring-white shadow-sm"></div>
                        <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Unit Usaha / UMKM</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map 2: Peta Listrik -->
    <section id="peta-listrik" class="py-24 bg-slate-50 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div class="text-left">
                    <h2 class="font-heading text-4xl font-bold text-slate-900 mb-4">Persebaran Kepemilikan Listrik</h2>
                    <p class="text-slate-600">Visualisasi jangkauan energi dan status kelistrikan setiap rumah tangga.</p>
                </div>
                
                <!-- Filters -->
                <div class="flex flex-wrap items-center gap-4 p-2 bg-white rounded-2xl shadow-sm border border-slate-200">
                    <div class="flex flex-col gap-1 px-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Status Listrik</label>
                        <select id="filterListrik" class="text-sm font-semibold text-slate-700 bg-transparent border-none focus:ring-0 cursor-pointer">
                            <option value="all">Semua Status</option>
                            <option value="listrik pln dengan meteran">PLN Meteran</option>
                            <option value="listrik pln tanpa meteran">PLN Non-Meteran</option>
                            <option value="bukan listrik pln">Bukan PLN</option>
                            <option value="tidak ada listrik">Tidak Ada Listrik</option>
                        </select>
                    </div>
                    <div class="w-px h-10 bg-slate-100"></div>
                    <div class="flex flex-col gap-1 px-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Wilayah RT/RW</label>
                        <select id="filterRtRw" class="text-sm font-semibold text-slate-700 bg-transparent border-none focus:ring-0 cursor-pointer">
                            <option value="all">Semua Wilayah</option>
                            @foreach($rtRwList as $rt)
                                <option value="{{ $rt }}">{{ $rt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-px h-10 bg-slate-100"></div>
                    <div class="flex items-center gap-3 px-4">
                        <label class="relative inline-flex items-center cursor-pointer group">
                            <input type="checkbox" id="toggleSls" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            <span class="ms-3 text-xs font-bold text-slate-500 uppercase group-hover:text-slate-700 transition-colors">Batas SLS</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="map-card bg-slate-200 relative border-slate-300">
                <div id="map-listrik" class="h-[600px] w-full"></div>
                <div class="absolute bottom-6 right-6 z-[1000] bg-white/95 backdrop-blur p-4 rounded-2xl shadow-2xl border border-slate-200">
                    <div class="space-y-2.5">
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-[#10b981] ring-2 ring-white shadow-sm"></div>
                            <span class="text-xs font-bold text-slate-700">PLN DENGAN METERAN</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-[#f59e0b] ring-2 ring-white shadow-sm"></div>
                            <span class="text-xs font-bold text-slate-700">PLN TANPA METERAN</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-[#3b82f6] ring-2 ring-white shadow-sm"></div>
                            <span class="text-xs font-bold text-slate-700">BUKAN LISTRIK PLN</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-[#ef4444] ring-2 ring-white shadow-sm"></div>
                            <span class="text-xs font-bold text-slate-700">TIDAK ADA LISTRIK</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Usaha Directory Section -->
    <section id="direktori" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-heading text-4xl font-bold text-slate-900 mb-4">Direktori UMKM & Usaha Desa</h2>
                <p class="text-slate-600">Dukung produk lokal dengan berbelanja di unit usaha warga desa kami.</p>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Nama Usaha / Pemilik</th>
                                <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Alamat</th>
                                <th class="px-8 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Wilayah</th>
                                <th class="px-8 py-5 text-right text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($usahaDirectory as $usaha)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center font-bold text-sm uppercase">
                                            {{ substr($usaha->nama_kepala_rumah, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-base leading-none mb-1">{{ $usaha->nama_kepala_rumah }}</div>
                                            <div class="text-xs text-slate-400 font-medium tracking-wide uppercase">Unit Ekonomi Desa</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-slate-600 font-medium">{{ $isAdmin ? $usaha->alamat : 'Alamat Disembunyikan' }}</td>
                                <td class="px-8 py-6 text-slate-500 font-bold text-sm">{{ $usaha->rt_rw }}</td>
                                <td class="px-8 py-6 text-right">
                                    <a href="#peta-usaha" class="px-4 py-2 rounded-xl bg-violet-50 text-violet-700 text-xs font-bold hover:bg-violet-100 transition-all">Lihat di Peta</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center text-slate-400 font-medium italic">Belum ada data unit usaha yang terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 py-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M21.53 7.15a1 1 0 00-1.06-.15l-4.5 2-4.5-2a1 1 0 00-.94 0l-4.5 2-4.5-2A1 1 0 000 8v11a1 1 0 00.53.88l5 2.5a1 1 0 00.94 0l4.5-2 4.5 2a1 1 0 00.94 0l5-2.5A1 1 0 0022 19V8a1 1 0 00-.47-.85z"/></svg>
                        </div>
                        <span class="font-heading font-bold text-2xl tracking-tight text-white">SIGAP<span class="text-emerald-500">Desa</span></span>
                    </div>
                    <p class="text-slate-500 text-sm">Sistem Informasi Geospasial Desa untuk pendataan yang lebih presisi dan akuntabel.</p>
                </div>
                <div class="text-slate-500 text-sm text-center md:text-right">
                    <p>© {{ date('Y') }} SIGAP Desa - Program Desa Cantik.</p>
                    <p class="mt-1">Powered by Leaflet Engine & Open Data Geospatial.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rumahData = @json($rumahData);
            const isAdmin = @json($isAdmin);

            // Default location: Tapin, Kalimantan Selatan
            const defaultLat = -2.9377;
            const defaultLng = 115.1539;
            const defaultZoom = 12;

            let centerLat = defaultLat;
            let centerLng = defaultLng;
            
            // Focus strictly on Tapin default unless filter is active
            // (Removed auto-centering to first house to keep focus on Tapin center)

            // --- TILE LAYERS ---
            const baseLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri'
            });

            const labelsLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
                subdomains: 'abcd',
                maxZoom: 20
            });

            // --- MAP 1: USAHA ---
            var mapUsaha = L.map('map-usaha', { 
                scrollWheelZoom: true,
                zoomControl: true,
                layers: [baseLayer, labelsLayer]
            }).setView([centerLat, centerLng], defaultZoom);

            // --- MAP 2: LISTRIK ---
            var mapListrik = L.map('map-listrik', { 
                scrollWheelZoom: true,
                zoomControl: true,
                layers: [
                    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { attribution: 'Esri' }),
                    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', { subdomains: 'abcd' })
                ]
            }).setView([centerLat, centerLng], defaultZoom);

            var boundsUsaha = L.latLngBounds();
            var boundsListrik = L.latLngBounds();
            
            // Icon Generator
            const getTeardropIcon = (color) => {
                const svgString = `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" 
                              fill="${color}" 
                              stroke="white" 
                              stroke-width="1.5" 
                              stroke-linejoin="round"/>
                    </svg>`;
                
                return L.divIcon({
                    className: 'custom-teardrop-icon',
                    html: svgString,
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -32]
                });
            };

            // Marker Groups
            var markersUsaha = L.markerClusterGroup();
            var markersListrik = L.markerClusterGroup();

            function updateMarkers(filterListrik = 'all', filterRtRw = 'all') {
                markersUsaha.clearLayers();
                markersListrik.clearLayers();
                boundsUsaha = L.latLngBounds();
                boundsListrik = L.latLngBounds();

                rumahData.forEach(function(item) {
                    var lat = parseFloat(item.latitude);
                    var lng = parseFloat(item.longitude);
                    if(isNaN(lat) || isNaN(lng)) return;

                    // Apply Filters (Only for Listrik Map)
                    const matchListrik = filterListrik === 'all' || item.status_listrik === filterListrik;
                    const matchRtRw = filterRtRw === 'all' || item.rt_rw === filterRtRw;

                    if (matchListrik && matchRtRw) {
                        // Logic for Listrik Map
                        let lColor = '';
                        let lLabel = '';
                        let lBadgeColor = '';
                        
                        if (item.status_listrik === 'listrik pln dengan meteran') { 
                            lColor = '#10b981'; lLabel = 'PLN DENGAN METERAN'; lBadgeColor = 'text-emerald-600';
                        } else if (item.status_listrik === 'listrik pln tanpa meteran') {
                            lColor = '#f59e0b'; lLabel = 'PLN TANPA METERAN'; lBadgeColor = 'text-amber-600';
                        } else if (item.status_listrik === 'bukan listrik pln') {
                            lColor = '#3b82f6'; lLabel = 'BUKAN LISTRIK PLN'; lBadgeColor = 'text-blue-600';
                        } else {
                            lColor = '#ef4444'; lLabel = 'TIDAK ADA LISTRIK'; lBadgeColor = 'text-rose-600';
                        }

                        var mListrik = L.marker([lat, lng], { icon: getTeardropIcon(lColor) });
                        mListrik.bindPopup(`
                            <div class="p-4">
                                <div class="text-[10px] font-extrabold ${lBadgeColor} uppercase tracking-widest mb-1">Status Energi</div>
                                <h4 class="font-bold text-slate-900 text-base mb-1">${item.nama_kepala_rumah}</h4>
                                <div class="text-xs font-semibold text-slate-500 mt-2">
                                    Status: ${lLabel}<br>
                                    Wilayah: ${item.rt_rw}
                                </div>
                                ${!isAdmin ? '<p class="mt-3 text-[10px] text-slate-400 italic leading-tight">* Detail nama dan alamat lengkap disembunyikan untuk privasi publik.</p>' : `<p class="mt-3 text-xs text-slate-600 border-t pt-2">${item.alamat}</p>`}
                            </div>
                        `);
                        markersListrik.addLayer(mListrik);
                        boundsListrik.extend([lat, lng]);
                    }

                    // Usaha Map stays unfiltered (or can be filtered if needed)
                    if (item.memiliki_usaha) {
                        var mUsaha = L.marker([lat, lng], { icon: getTeardropIcon('#8b5cf6') });
                        mUsaha.bindPopup(`
                            <div class="p-4">
                                <div class="text-[10px] font-extrabold text-violet-600 uppercase tracking-widest mb-1">Unit Ekonomi</div>
                                <h4 class="font-bold text-slate-900 text-base mb-1">${item.nama_kepala_rumah}</h4>
                                <div class="bg-violet-50 text-violet-700 px-3 py-1 rounded-lg text-xs font-bold inline-block mt-2">
                                    MEMILIKI USAHA/UMKM
                                </div>
                                ${!isAdmin ? '<p class="mt-3 text-[10px] text-slate-400 italic leading-tight">* Detail nama dan alamat lengkap disembunyikan untuk privasi publik.</p>' : `<p class="mt-3 text-xs text-slate-600 border-t pt-2">${item.alamat}</p>`}
                            </div>
                        `);
                        markersUsaha.addLayer(mUsaha);
                        boundsUsaha.extend([lat, lng]);
                    }
                });

                if (markersUsaha.getLayers().length > 0) mapUsaha.fitBounds(boundsUsaha, { padding: [50, 50] });
                if (markersListrik.getLayers().length > 0) mapListrik.fitBounds(boundsListrik, { padding: [50, 50] });
            }

            // --- GEOJSON BOUNDARIES ---
            const geojsonPath = '/geojson/SLS_SubSLS_6305_rev2 - layout.geojson';
            let geojsonLayerUsaha = null;
            let geojsonLayerListrik = null;
            let geojsonData = null; // Cache data
            
            function loadGeoJSON() {
                if (geojsonData) {
                    renderGeoJSON();
                    return;
                }

                fetch(geojsonPath)
                    .then(response => response.json())
                    .then(data => {
                        geojsonData = data;
                        renderGeoJSON();
                    })
                    .catch(error => console.error('Error loading GeoJSON:', error));
            }

            function renderGeoJSON() {
                const style = {
                    color: '#10b981',
                    weight: 2,
                    opacity: 0.6,
                    fillColor: '#10b981',
                    fillOpacity: 0.05,
                    dashArray: '5, 5'
                };

                const onEachFeature = function(feature, layer) {
                    if (feature.properties && feature.properties.nmsls) {
                        layer.bindTooltip(`<strong>${feature.properties.nmsls}</strong><br>${feature.properties.nmdesa}`, {
                            sticky: true,
                            className: 'custom-tooltip'
                        });
                        
                        layer.on('mouseover', function() {
                            this.setStyle({ fillOpacity: 0.2, weight: 3 });
                        });
                        layer.on('mouseout', function() {
                            this.setStyle({ fillOpacity: 0.05, weight: 2 });
                        });
                    }
                };

                geojsonLayerUsaha = L.geoJSON(geojsonData, { style, onEachFeature }).addTo(mapUsaha);
                geojsonLayerListrik = L.geoJSON(geojsonData, { style, onEachFeature }).addTo(mapListrik);
            }

            function toggleSLS(show) {
                if (show) {
                    if (!geojsonLayerUsaha) loadGeoJSON();
                    else {
                        mapUsaha.addLayer(geojsonLayerUsaha);
                        mapListrik.addLayer(geojsonLayerListrik);
                    }
                } else {
                    if (geojsonLayerUsaha) mapUsaha.removeLayer(geojsonLayerUsaha);
                    if (geojsonLayerListrik) mapListrik.removeLayer(geojsonLayerListrik);
                }
            }

            // Initial Load
            loadGeoJSON();

            // Toggle Listener
            document.getElementById('toggleSls').addEventListener('change', (e) => {
                toggleSLS(e.target.checked);
            });

            // Initial Markers
            mapUsaha.addLayer(markersUsaha);
            mapListrik.addLayer(markersListrik);
            updateMarkers();

            // Filter Event Listeners
            document.getElementById('filterListrik').addEventListener('change', (e) => {
                updateMarkers(e.target.value, document.getElementById('filterRtRw').value);
            });
            document.getElementById('filterRtRw').addEventListener('change', (e) => {
                updateMarkers(document.getElementById('filterListrik').value, e.target.value);
            });

            // --- CHARTS INITIALIZATION ---
            
            // 1. Chart Listrik
            const ctxListrik = document.getElementById('chartListrik').getContext('2d');
            const lData = @json($listrikStats);
            new Chart(ctxListrik, {
                type: 'doughnut',
                data: {
                    labels: lData.map(i => i.status_listrik.toUpperCase()),
                    datasets: [{
                        data: lData.map(i => i.total),
                        backgroundColor: ['#10b981', '#f59e0b', '#3b82f6', '#ef4444'],
                        borderWidth: 8,
                        borderColor: '#f8fafc', // Same as bg-slate-50
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false } // Custom legend used in HTML
                    },
                    cutout: '80%'
                }
            });
        });
    </script>
</body>
</html>
