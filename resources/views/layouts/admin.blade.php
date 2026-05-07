<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-relax">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - SIGAP Desa</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full bg-slate-50 text-gray-800" x-data="{ sidebarOpen: false }">

    <!-- Mobile sidebar backdrop -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-gray-900/60 lg:hidden" @click="sidebarOpen = false"></div>

    <div class="flex h-full">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 flex flex-col shadow-sm">
            
            <!-- Logo area -->
            <div class="flex items-center h-16 px-6 border-b border-gray-100 bg-white">
                <div class="flex items-center gap-2">
                    <svg class="w-7 h-7 text-emerald-600" viewBox="0 0 24 24" fill="currentColor"><path d="M21.53 7.15a1 1 0 00-1.06-.15l-4.5 2-4.5-2a1 1 0 00-.94 0l-4.5 2-4.5-2A1 1 0 000 8v11a1 1 0 00.53.88l5 2.5a1 1 0 00.94 0l4.5-2 4.5 2a1 1 0 00.94 0l5-2.5A1 1 0 0022 19V8a1 1 0 00-.47-.85zM11 18.28l-4-1.78v-7.5l4 1.78v7.5zm1-8.56l4-1.78v7.5l-4 1.78v-7.5zM6 8.35L10.32 10.27 6 12.19 1.68 10.27 6 8.35z"/></svg>
                    <span class="text-xl font-bold text-gray-900 tracking-tight">SIGAP<span class="text-emerald-600">Desa</span></span>
                </div>
                <button @click="sidebarOpen = false" class="ml-auto lg:hidden text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto text-sm font-medium">
                @hasrole('admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-emerald-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard Admin
                </a>
                
                <div class="pt-4 pb-1">
                    <p class="px-3 text-xs font-bold tracking-wider text-gray-400 uppercase">Master Data</p>
                </div>
                
                <a href="{{ route('admin.penduduk.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.penduduk.*') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.penduduk.*') ? 'text-emerald-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Data Penduduk
                </a>
                
                <a href="{{ route('admin.usaha.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.usaha.*') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.usaha.*') ? 'text-emerald-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Data Usaha
                </a>

                <div class="pt-4 pb-1">
                    <p class="px-3 text-xs font-bold tracking-wider text-gray-400 uppercase">Pemetaan GIS</p>
                </div>

                <a href="{{ route('admin.map.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.map.*') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.map.*') ? 'text-emerald-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Peta Persebaran
                </a>
                @endhasrole

                @hasrole('mitra')
                <div class="pt-2 pb-1">
                    <p class="px-3 text-xs font-bold tracking-wider text-gray-400 uppercase">Ruang Mitra</p>
                </div>
                
                <a href="{{ route('mitra.survei.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('mitra.survei.*') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('mitra.survei.*') ? 'text-emerald-600' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Riwayat Survei
                </a>
                @endhasrole
            </nav>

            <!-- User profile bottom -->
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-3 px-2">
                    <div class="w-9 h-9 rounded-full bg-emerald-100 border border-emerald-200 flex items-center justify-center text-sm font-bold text-emerald-700 shadow-sm">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="flex flex-col flex-1 truncate">
                        <span class="text-sm font-bold text-gray-900">{{ Auth::user()->name ?? 'Administrator' }}</span>
                        <span class="text-xs text-gray-500 font-medium">{{ Auth::user()->roles->first()->name ?? 'Role' }}</span>
                    </div>
                </div>
                <form method="POST" action="#" class="mt-3">
                    @csrf
                    <button class="w-full text-left px-3 py-2 text-sm font-medium text-gray-600 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Sign out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Navbar -->
            <header class="h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 shrink-0 bg-white border-b border-gray-200 shadow-sm z-10">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 rounded-md text-gray-500 hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h1 class="text-lg font-bold text-gray-800 hidden sm:block">@yield('title', 'Dashboard')</h1>
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- Search bar -->
                    <div class="hidden md:block relative w-64">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" class="w-full py-2 pl-10 pr-3 text-sm bg-gray-100 border-transparent rounded-lg focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all" placeholder="Pencarian cepat...">
                    </div>
                </div>
            </header>

            <!-- Scrollable Area -->
            <div class="flex-1 overflow-y-auto bg-slate-50 p-4 sm:p-6 lg:p-8">
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 text-emerald-800 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    @stack('scripts')
</body>
</html>
