@extends('admin.layout')

@section('title', 'Insights')

@section('content')
<!-- Hero Intelligence Surface -->
<section class="grid gap-8 xl:grid-cols-[1fr_400px]">
    <div class="relative overflow-hidden rounded-[48px] border border-black/[0.03] bg-white p-10 shadow-2xl shadow-black/[0.02] sm:p-14">
        <!-- Decorative Element -->
        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-[#f1ece4]/40 blur-3xl"></div>
        
        <div class="relative">
            <div class="flex items-center gap-3">
                <span class="h-2 w-2 rounded-full bg-[#7a8a6b]"></span>
                <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-[#7a8a6b]">Intelligence Dashboard</p>
            </div>
            <h2 class="mt-8 max-w-2xl font-[Playfair Display] text-5xl font-bold leading-[1.1] text-black sm:text-6xl italic">
                Quantifying <span class="text-[#a89078] not-italic">Design Evolution</span> & User Engagement.
            </h2>
            <p class="mt-8 max-w-xl text-[15px] leading-relaxed font-medium text-[#5f5750]">
                A real-time synthesis of Homiq's ecosystem performance. From spatial transformations to commercial growth, every pixel serves a purpose in our core analytics engine.
            </p>

            <div class="mt-14 grid gap-6 sm:grid-cols-3">
                <div class="group rounded-[32px] bg-[#fbfaf8] p-7 transition-all duration-500 hover:bg-black hover:text-white hover:-translate-y-1">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-hover:text-[#7a8a6b]">Monthly Vol.</p>
                    <p class="mt-4 text-5xl font-bold tracking-tighter">{{ number_format($stats['monthly_designs']) }}</p>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#7a8a6b]/10 text-[10px] text-[#7a8a6b] group-hover:bg-white/10 group-hover:text-white">
                            <i class="fa-solid fa-arrow-up"></i>
                        </span>
                        <p class="text-[11px] font-bold tracking-tight">+{{ number_format($stats['today_designs']) }} today</p>
                    </div>
                </div>
                <div class="group rounded-[32px] bg-[#eef3ea]/60 p-7 transition-all duration-500 hover:bg-black hover:text-white hover:-translate-y-1">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b]">Active Base</p>
                    <p class="mt-4 text-5xl font-bold tracking-tighter">{{ number_format($stats['active_users']) }}</p>
                    <p class="mt-4 text-[11px] font-bold tracking-tight text-[#5f5750] group-hover:text-white/70">Rolling 30-day index</p>
                </div>
                <div class="group rounded-[32px] bg-[#f3ece4]/60 p-7 transition-all duration-500 hover:bg-black hover:text-white hover:-translate-y-1">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#8b745d] group-hover:text-[#a89078]">Conversion</p>
                    <p class="mt-4 text-5xl font-bold tracking-tighter">{{ $stats['conversion_rate'] }}%</p>
                    <p class="mt-4 text-[11px] font-bold tracking-tight text-[#5f5750] group-hover:text-white/70">{{ number_format($stats['premium_users']) }} Pro members</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-8">
        <!-- Live Ecosystem Pulse -->
        <div class="flex-1 overflow-hidden rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-[Playfair Display] text-2xl font-bold text-black">Ecosystem</h3>
                    <p class="mt-1 text-[9px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Live Pulse</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#faf7f2] shadow-inner ring-1 ring-black/[0.02]">
                    <i class="fa-solid fa-satellite-dish text-sm text-[#a89078] animate-pulse"></i>
                </div>
            </div>

            <div class="mt-8 space-y-6">
                <div class="group relative overflow-hidden rounded-[28px] border border-black/[0.03] bg-[#fbfaf8] p-6 transition-all hover:bg-white hover:shadow-lg">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold text-[#5f5750]">Total Audience</p>
                        <span class="text-[10px] font-bold text-[#7a8a6b]">{{ number_format($stats['monthly_users']) }} new</span>
                    </div>
                    <p class="mt-3 text-4xl font-bold text-black tracking-tighter">{{ number_format($stats['total_users']) }}</p>
                    <div class="mt-4 h-1.5 w-full overflow-hidden rounded-full bg-black/[0.03]">
                        <div class="h-full bg-[#7a8a6b] rounded-full" style="width: 65%"></div>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-[28px] bg-black p-6 shadow-2xl shadow-black/20">
                    <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-white/5 blur-2xl"></div>
                    <div class="flex items-center justify-between text-white/50">
                        <p class="text-xs font-bold">Revenue Cap</p>
                        <i class="fa-solid fa-chart-line text-[10px]"></i>
                    </div>
                    <p class="mt-3 text-4xl font-bold text-white tracking-tighter">₹{{ number_format($stats['revenue']) }}</p>
                    <p class="mt-4 text-[10px] font-bold uppercase tracking-widest text-[#a89078]">Aggregated Subscriptions</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Secondary Metrics Grid -->
<section class="mt-8 grid gap-8 md:grid-cols-2 xl:grid-cols-4">
    @foreach([
        ['label' => 'Community', 'value' => $stats['total_users'], 'icon' => 'fa-users', 'bg' => 'bg-[#f1f3f0]', 'color' => 'text-[#7a8a6b]', 'sub' => 'Global members'],
        ['label' => 'AI Volume', 'value' => $stats['total_designs'], 'icon' => 'fa-wand-magic-sparkles', 'bg' => 'bg-[#f7f2ed]', 'color' => 'text-[#a89078]', 'sub' => 'spatial-ai requests'],
        ['label' => 'Retention', 'value' => $stats['daily_active_users'], 'icon' => 'fa-bolt-lightning', 'bg' => 'bg-[#f9f7f4]', 'color' => 'text-[#8b745d]', 'sub' => 'Daily active core'],
        ['label' => 'Alerts', 'value' => $stats['failed_designs'], 'icon' => 'fa-triangle-exclamation', 'bg' => 'bg-[#f7e9e9]', 'color' => 'text-[#8c4343]', 'sub' => 'Critical incidents']
    ] as $metric)
    <article class="group relative overflow-hidden rounded-[36px] border border-black/[0.03] bg-white p-8 shadow-sm transition-all hover:-translate-y-1 hover:shadow-2xl hover:shadow-black/[0.04]">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $metric['bg'] }} {{ $metric['color'] }} shadow-sm ring-1 ring-black/[0.02]">
                <i class="fa-solid {{ $metric['icon'] }} text-sm"></i>
            </div>
            <span class="text-[9px] font-bold uppercase tracking-widest text-[#a89078] opacity-0 group-hover:opacity-100 transition-opacity">Live Data</span>
        </div>
        <p class="mt-8 text-xs font-bold uppercase tracking-widest text-[#5f5750]/60">{{ $metric['label'] }}</p>
        <p class="mt-2 text-4xl font-bold tracking-tighter text-black">{{ is_numeric($metric['value']) ? number_format($metric['value']) : $metric['value'] }}</p>
        <p class="mt-4 text-[11px] font-bold text-[#7a8a6b]">{{ $metric['sub'] }}</p>
    </article>
    @endforeach
</section>

<!-- Data Stream & Analytics -->
<section class="mt-8 grid gap-8 xl:grid-cols-[1fr_450px]">
    <!-- Activity Stream -->
    <div class="rounded-[40px] border border-black/[0.03] bg-white p-10 shadow-xl shadow-black/[0.02]">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-[Playfair Display] text-3xl font-bold text-black">Data Stream</h2>
                <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Real-time spatial activity</p>
            </div>
            <a href="{{ route('admin.designs') }}" class="group inline-flex items-center gap-2 rounded-2xl bg-[#faf7f2] px-6 py-3.5 text-[11px] font-bold uppercase tracking-widest text-black transition-all hover:bg-black hover:text-white">
                Historical Archive
                <i class="fa-solid fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <div class="mt-10 overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-black/[0.03] text-[10px] font-bold uppercase tracking-[0.3em] text-[#a89078]">
                        <th class="pb-6 text-left pl-2">Subject</th>
                        <th class="pb-6 text-left">Aesthetic Context</th>
                        <th class="pb-6 text-center">Protocol Status</th>
                        <th class="pb-6 text-right pr-2">Relative Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/[0.02]">
                    @forelse($stats['recent_activity'] as $activity)
                    <tr class="group transition-colors hover:bg-[#faf7f2]/40">
                        <td class="py-6 pl-2">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-black/5 text-[15px] font-bold text-black shadow-inner">
                                    {{ strtoupper(substr($activity->user->name ?? 'G', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-[14px] font-bold text-black">{{ $activity->user->name ?? 'Anonymous' }}</p>
                                    <p class="truncate text-[11px] font-medium text-[#7a8a6b]">{{ $activity->user->email ?? 'No secure address' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-6">
                            <span class="inline-flex items-center gap-2 rounded-xl bg-black/[0.03] px-3.5 py-2 text-[11px] font-bold text-[#5f5750]">
                                <i class="fa-solid fa-swatchbook text-[9px] text-[#a89078]"></i>
                                {{ $activity->style->name ?? 'Modernist' }}
                            </span>
                        </td>
                        <td class="py-6 text-center">
                            @php
                                $statusMeta = match($activity->status) {
                                    'completed' => ['bg' => 'bg-[#eef3ea]', 'text' => 'text-[#405038]', 'icon' => 'fa-check'],
                                    'processing' => ['bg' => 'bg-[#f7f2ea]', 'text' => 'text-[#7e6852]', 'icon' => 'fa-ellipsis'],
                                    'failed' => ['bg' => 'bg-[#f7e9e9]', 'text' => 'text-[#8c4343]', 'icon' => 'fa-xmark'],
                                    default => ['bg' => 'bg-black/5', 'text' => 'text-black/60', 'icon' => 'fa-circle'],
                                };
                            @endphp
                            <span class="inline-flex items-center gap-2 rounded-full {{ $statusMeta['bg'] }} px-4 py-1.5 text-[9px] font-bold uppercase tracking-[0.15em] {{ $statusMeta['text'] }}">
                                <i class="fa-solid {{ $statusMeta['icon'] }} text-[8px]"></i>
                                {{ $activity->status }}
                            </span>
                        </td>
                        <td class="py-6 text-right pr-2">
                            <p class="text-[11px] font-bold text-[#a89078]">{{ $activity->created_at?->diffForHumans() }}</p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-16 text-center">
                            <p class="text-sm font-bold text-[#a89078]">No spatial activity recorded in this sequence.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right Column: System Health & Trends -->
    <div class="flex flex-col gap-8">
        <!-- Growth Visualization -->
        <div class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-[Playfair Display] text-2xl font-bold text-black">Temporal Growth</h3>
                    <p class="mt-1 text-[9px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Performance Delta</p>
                </div>
                <div class="flex gap-4">
                    <div class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-[#7a8a6b]"></span><span class="text-[9px] font-bold text-[#5f5750]">U</span></div>
                    <div class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-[#a89078]"></span><span class="text-[9px] font-bold text-[#5f5750]">D</span></div>
                </div>
            </div>

            <div class="mt-10 flex h-[240px] items-end justify-between gap-2">
                @php $maxGrowth = max(1, $stats['growth']->max(fn($d) => max($d['users'], $d['designs']))); @endphp
                @foreach($stats['growth'] as $day)
                <div class="group relative flex flex-1 flex-col items-center gap-4">
                    <div class="flex w-full items-end justify-center gap-1">
                        <div class="w-2 rounded-full bg-[#7a8a6b]/20 transition-all group-hover:bg-[#7a8a6b]" style="height: {{ max(4, ($day['users'] / $maxGrowth) * 200) }}px"></div>
                        <div class="w-2 rounded-full bg-[#a89078]/20 transition-all group-hover:bg-[#a89078]" style="height: {{ max(4, ($day['designs'] / $maxGrowth) * 200) }}px"></div>
                    </div>
                    <p class="text-[8px] font-bold uppercase tracking-tighter text-[#a89078]">{{ substr($day['label'], 0, 3) }}</p>
                    
                    <!-- Tooltip -->
                    <div class="absolute -top-12 left-1/2 -translate-x-1/2 scale-0 rounded-xl bg-black px-3 py-2 text-[10px] font-bold text-white shadow-2xl transition-all group-hover:scale-100 z-10 whitespace-nowrap">
                        {{ $day['users'] }}U | {{ $day['designs'] }}D
                        <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 h-2 w-2 rotate-45 bg-black"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Infrastructure Health -->
        <div class="rounded-[40px] border border-black/[0.03] bg-white p-8 shadow-xl shadow-black/[0.02]">
            <h3 class="font-[Playfair Display] text-2xl font-bold text-black">Infrastructure</h3>
            <p class="mt-1 text-[9px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">System Integrity</p>

            <div class="mt-8 space-y-3">
                @foreach([
                    ['label' => 'Process Success', 'value' => $stats['completed_designs'], 'bg' => 'bg-[#eef3ea]', 'text' => 'text-[#405038]'],
                    ['label' => 'Live Queue', 'value' => $stats['processing_designs'], 'bg' => 'bg-[#faf7f2]', 'text' => 'text-[#7e6852]'],
                    ['label' => 'Protocol Failure', 'value' => $stats['failed_designs'], 'bg' => 'bg-[#f7e9e9]', 'text' => 'text-[#8c4343]']
                ] as $health)
                <div class="flex items-center justify-between rounded-2xl {{ $health['bg'] }} px-5 py-4 border border-black/[0.02]">
                    <span class="text-xs font-bold {{ $health['text'] }}">{{ $health['label'] }}</span>
                    <strong class="text-[15px] font-bold text-black">{{ number_format($health['value']) }}</strong>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Roadmap & Modules -->
<section class="mt-8 mb-12 rounded-[48px] border border-black/[0.03] bg-white p-10 shadow-xl shadow-black/[0.02]">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="font-[Playfair Display] text-3xl font-bold text-black italic">Operational Roadmap</h2>
            <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">System architecture & future-state modules</p>
        </div>
        <div class="flex h-10 items-center gap-2 rounded-full bg-[#faf7f2] px-4 ring-1 ring-black/[0.03]">
            <span class="h-1.5 w-1.5 rounded-full bg-[#7a8a6b] animate-pulse"></span>
            <span class="text-[10px] font-bold uppercase tracking-widest text-[#5f5750]">Core Version 2.4.0</span>
        </div>
    </div>

    <div class="mt-10 grid gap-6 xl:grid-cols-2">
        @foreach ($stats['feature_modules'] as $module)
        <article class="group relative overflow-hidden rounded-[32px] border border-black/[0.03] bg-[#fbfaf8] p-8 transition-all hover:bg-white hover:shadow-2xl hover:shadow-black/[0.04]">
            <div class="flex items-center justify-between">
                <h3 class="text-[15px] font-bold text-black group-hover:text-[#a89078] transition-colors">{{ $module['title'] }}</h3>
                @php
                    $tagMeta = match($module['status']) {
                        'Live' => ['bg' => 'bg-[#eef3ea]', 'text' => 'text-[#405038]'],
                        'Next' => ['bg' => 'bg-[#faf7f2]', 'text' => 'text-[#a89078]'],
                        default => ['bg' => 'bg-black/5', 'text' => 'text-black/60'],
                    };
                @endphp
                <span class="rounded-full {{ $tagMeta['bg'] }} px-4 py-1.5 text-[9px] font-bold uppercase tracking-widest {{ $tagMeta['text'] }}">
                    {{ $module['status'] }}
                </span>
            </div>
            <p class="mt-5 text-[13px] leading-relaxed font-medium text-[#5f5750]/80">
                {{ $module['description'] }}
            </p>
            <div class="mt-6 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#a89078]">Explore documentation</span>
                <i class="fa-solid fa-chevron-right text-[8px] text-[#a89078]"></i>
            </div>
        </article>
        @endforeach
    </div>
</section>
@endsection


