@extends('admin.layout')

@section('title', 'Security Logs')

@section('content')
<div class="space-y-10">
    <!-- Telemetry Surfaces -->
    <section class="grid grid-cols-1 gap-10 sm:grid-cols-3">
        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02] transition-transform hover:scale-[1.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Traffic Volume</p>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="font-[Playfair Display] text-4xl font-bold text-black italic">{{ number_format($summary['total_requests']) }}</span>
                <span class="text-[10px] font-bold text-[#7a8a6b]/60 uppercase tracking-widest">Calls / 24h</span>
            </div>
        </article>

        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02] transition-transform hover:scale-[1.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#8c4343]">Error Manifest</p>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="font-[Playfair Display] text-4xl font-bold text-black italic">{{ number_format($summary['failed_requests']) }}</span>
                <span class="text-[10px] font-bold text-[#8c4343]/60 uppercase tracking-widest">Failed</span>
            </div>
        </article>

        <article class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02] transition-transform hover:scale-[1.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">System Pulse</p>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="font-[Playfair Display] text-4xl font-bold text-black italic">{{ $summary['avg_duration'] }}ms</span>
                <span class="text-[10px] font-bold text-[#7a8a6b]/60 uppercase tracking-widest">Avg Latency</span>
            </div>
        </article>
    </section>

    <!-- Activity Manifest -->
    <section class="rounded-[56px] border border-black/[0.03] bg-white overflow-hidden shadow-2xl shadow-black/[0.03]">
        <header class="px-12 py-10 bg-[#faf9f6] flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between border-b border-black/[0.03]">
            <div>
                <h2 class="font-[Playfair Display] text-3xl font-bold text-black italic">Traffic Manifest</h2>
                <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Live cryptographic stream monitoring</p>
            </div>
            
            <form action="{{ route('admin.logs') }}" method="GET">
                <select name="status" onchange="this.form.submit()" class="rounded-full border border-black/[0.05] bg-white px-8 py-3 text-[11px] font-bold uppercase tracking-widest text-black focus:border-black focus:ring-8 focus:ring-black/5 outline-none transition-all appearance-none cursor-pointer">
                    <option value="">Full Archive</option>
                    <option value="200" {{ request('status') == '200' ? 'selected' : '' }}>200 OK</option>
                    <option value="400" {{ request('status') == '400' ? 'selected' : '' }}>400 Fault</option>
                    <option value="401" {{ request('status') == '401' ? 'selected' : '' }}>401 Guard</option>
                    <option value="500" {{ request('status') == '500' ? 'selected' : '' }}>500 Critical</option>
                </select>
            </form>
        </header>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#a89078] bg-white border-b border-black/[0.02]">
                        <th class="pl-12 pr-6 py-8">Protocol</th>
                        <th class="px-6 py-8">Resource Vector</th>
                        <th class="px-6 py-8">Identity</th>
                        <th class="px-6 py-8 text-center">Pulse</th>
                        <th class="pl-6 pr-12 py-8 text-right">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/[0.02]">
                    @forelse($logs as $log)
                    <tr class="hover:bg-[#faf9f6]/50 transition-colors group">
                        <td class="pl-12 pr-6 py-7">
                            <span class="inline-flex items-center justify-center rounded-full px-4 py-1 text-[10px] font-bold tracking-tighter {{ $log->status_code < 400 ? 'bg-[#7a8a6b]/10 text-[#7a8a6b]' : 'bg-[#8c4343]/10 text-[#8c4343]' }}">
                                {{ $log->status_code }}
                            </span>
                        </td>
                        <td class="px-6 py-7">
                            <div class="flex items-center gap-4">
                                <span class="text-[11px] font-bold text-black uppercase tracking-widest w-8 opacity-40 group-hover:opacity-100 transition-opacity">{{ $log->method }}</span>
                                <span class="text-[13px] font-medium text-black font-mono tracking-tight">{{ Str::after($log->url, 'api/') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-7">
                            <div class="flex flex-col">
                                <span class="text-[13px] font-bold text-black">{{ $log->user->name ?? 'System Guest' }}</span>
                                <span class="text-[10px] font-medium text-[#a89078] tracking-widest uppercase mt-0.5 opacity-60">{{ $log->ip_address }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-7 text-center">
                            <span class="text-[13px] font-mono {{ $log->duration_ms > 500 ? 'text-[#8c4343] font-bold' : 'text-[#7a8a6b]' }}">
                                {{ $log->duration_ms }}<span class="text-[10px] opacity-40 ml-0.5">ms</span>
                            </span>
                        </td>
                        <td class="pl-6 pr-12 py-7 text-right">
                            <span class="text-[12px] font-bold text-black tabular-nums">{{ $log->created_at->format('H:i:s') }}</span>
                            <span class="text-[10px] text-[#a89078] font-bold block mt-0.5 opacity-40">{{ $log->created_at->format('M d') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-32 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-wind text-4xl text-black/5 mb-6"></i>
                                <p class="text-[13px] font-bold text-black uppercase tracking-[0.2em] opacity-30">Manifest empty. No traffic detected.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <footer class="px-12 py-10 bg-[#faf9f6] border-t border-black/[0.03]">
            <div class="pagination-editorial">
                {{ $logs->links() }}
            </div>
        </footer>
        @endif
    </section>
</div>
@endsection

