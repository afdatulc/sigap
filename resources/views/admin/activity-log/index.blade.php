@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Log Aktivitas Admin</h2>
            <p class="text-sm text-gray-500 mt-1">Rekaman aktivitas operasional sistem oleh administrator dan mitra.</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aktivitas</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Detail</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">IP Address</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $log->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 text-[10px] font-bold">
                                    {{ substr($log->user->name ?? '?', 0, 2) }}
                                </div>
                                <div class="text-sm font-semibold text-gray-900">{{ $log->user->name ?? 'System' }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold 
                                {{ str_contains(strtolower($log->aktivitas), 'tambah') ? 'bg-blue-50 text-blue-700' : '' }}
                                {{ str_contains(strtolower($log->aktivitas), 'hapus') ? 'bg-rose-50 text-rose-700' : '' }}
                                {{ str_contains(strtolower($log->aktivitas), 'ubah') ? 'bg-amber-50 text-amber-700' : '' }}
                                {{ str_contains(strtolower($log->aktivitas), 'login') ? 'bg-emerald-50 text-emerald-700' : '' }}
                                {{ !str_contains(strtolower($log->aktivitas), 'tambah') && !str_contains(strtolower($log->aktivitas), 'hapus') && !str_contains(strtolower($log->aktivitas), 'ubah') && !str_contains(strtolower($log->aktivitas), 'login') ? 'bg-gray-50 text-gray-700' : '' }}
                            ">
                                {{ $log->aktivitas }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $log->detail ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 font-mono">
                            {{ $log->ip_address ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                            Belum ada log aktivitas yang tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
