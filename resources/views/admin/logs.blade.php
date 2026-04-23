@extends('admin.layout')

@section('title', 'Security & System Logs')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
        <div class="rounded-[32px] border border-black/5 bg-white p-6 shadow-[0_16px_40px_rgba(31,31,31,0.04)]">
            <p class="text-xs font-semibold uppercase tracking-wider text-[#7a8a6b]">Total API Calls (24h)</p>
            <p class="mt-2 text-3xl font-bold text-[#171717]">{{ $summary['total_requests'] }}</p>
        </div>
        <div class="rounded-[32px] border border-black/5 bg-white p-6 shadow-[0_16px_40px_rgba(31,31,31,0.04)]">
            <p class="text-xs font-semibold uppercase tracking-wider text-red-500">Failed Requests</p>
            <p class="mt-2 text-3xl font-bold text-[#171717]">{{ $summary['failed_requests'] }}</p>
        </div>
        <div class="rounded-[32px] border border-black/5 bg-white p-6 shadow-[0_16px_40px_rgba(31,31,31,0.04)]">
            <p class="text-xs font-semibold uppercase tracking-wider text-[#7a8a6b]">Avg Latency</p>
            <p class="mt-2 text-3xl font-bold text-[#171717]">{{ $summary['avg_duration'] }}ms</p>
        </div>
    </div>

    <div class="rounded-[34px] border border-black/6 bg-white overflow-hidden shadow-[0_22px_60px_rgba(31,31,31,0.06)]">
        <div class="px-8 py-6 border-b border-black/5 bg-[#fbfaf8] flex justify-between items-center">
            <h2 class="font-[Playfair Display] text-2xl text-[#171717]">Live API Traffic</h2>
            <form action="{{ route('admin.logs') }}" method="GET" class="flex gap-2">
                <select name="status" onchange="this.form.submit()" class="rounded-full border-black/10 bg-white px-4 py-1.5 text-xs font-bold focus:border-[#7a8a6b] focus:ring-[#7a8a6b]">
                    <option value="">All Status</option>
                    <option value="200" {{ request('status') == '200' ? 'selected' : '' }}>200 OK</option>
                    <option value="400" {{ request('status') == '400' ? 'selected' : '' }}>400 Bad Request</option>
                    <option value="401" {{ request('status') == '401' ? 'selected' : '' }}>401 Unauthorized</option>
                    <option value="500" {{ request('status') == '500' ? 'selected' : '' }}>500 Server Error</option>
                </select>
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-black/5 text-[10px] font-bold uppercase tracking-widest text-[#7a8a6b] bg-[#f8f5ef]">
                        <th class="px-8 py-4">Status</th>
                        <th class="py-4">Method & URL</th>
                        <th class="py-4">User</th>
                        <th class="py-4">Latency</th>
                        <th class="px-8 py-4 text-right">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse($logs as $log)
                    <tr class="hover:bg-[#fbfaf8] transition group">
                        <td class="px-8 py-4">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-[10px] font-bold {{ $log->status_code < 400 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $log->status_code }}
                            </span>
                        </td>
                        <td class="py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] font-bold text-[#171717] w-10">{{ $log->method }}</span>
                                <span class="text-xs text-[#5f5a52] truncate max-w-[250px] font-mono">{{ Str::after($log->url, 'api/') }}</span>
                            </div>
                        </td>
                        <td class="py-4">
                            <span class="text-xs font-medium text-[#171717]">{{ $log->user->name ?? 'Guest' }}</span>
                            <p class="text-[10px] text-[#7a8a6b]">{{ $log->ip_address }}</p>
                        </td>
                        <td class="py-4">
                            <span class="text-xs font-mono {{ $log->duration_ms > 500 ? 'text-red-500 font-bold' : 'text-[#5f5a52]' }}">
                                {{ $log->duration_ms }}ms
                            </span>
                        </td>
                        <td class="px-8 py-4 text-right text-[10px] font-bold text-[#5f5a52] uppercase tracking-tighter">
                            {{ $log->created_at->format('H:i:s.v') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-20 text-center">
                            <i class="fa-solid fa-shield-halved text-5xl text-black/10 mb-4"></i>
                            <p class="text-[#5f5a52]">No activity logs found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="px-8 py-4 border-t border-black/5 bg-[#fbfaf8]">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
