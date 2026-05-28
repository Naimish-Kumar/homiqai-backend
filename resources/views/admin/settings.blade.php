@extends('admin.layout')

@section('title', 'Configuration')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-10">
    @csrf

    <!-- Control Center Surfaces -->
    <section class="grid gap-10 xl:grid-cols-3">
        <!-- AI Intelligence Protocols -->
        <article class="rounded-[48px] border border-black/[0.03] bg-white p-10 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">AI Intelligence</p>
            <h2 class="mt-4 font-[Playfair Display] text-3xl font-bold text-black italic">Engine Protocols</h2>

            <div class="mt-10 space-y-8">
                <label class="block group">
                    <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Primary Vision Provider</span>
                    <select name="ai_provider" id="ai_provider" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none appearance-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                        <option value="stability" {{ $config['ai_provider'] == 'stability' ? 'selected' : '' }}>Stability AI (SD3-Turbo)</option>
                        <option value="openai" {{ $config['ai_provider'] == 'openai' ? 'selected' : '' }}>OpenAI (DALL-E 3)</option>
                    </select>
                </label>

                <label class="block group">
                    <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Stability AI Vault Key</span>
                    <input type="password" name="stability_ai_key" id="stability_ai_key" value="{{ $config['stability_ai_key'] }}" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none shadow-sm focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all" placeholder="sk-vault-...">
                </label>

                <label class="block group">
                    <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">OpenAI API Authorization</span>
                    <input type="password" name="openai_key" id="openai_key" value="{{ $config['openai_key'] }}" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none shadow-sm focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all" placeholder="sk-auth-...">
                </label>

                <label class="block group">
                    <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Gemini API Authorization</span>
                    <input type="password" name="gemini_key" id="gemini_key" value="{{ $config['gemini_key'] }}" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none shadow-sm focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all" placeholder="AIzaSy...">
                </label>
            </div>
        </article>

        <!-- Prompt Architecture -->
        <article class="rounded-[48px] border border-black/[0.03] bg-white p-10 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Global Prompting</p>
            <h2 class="mt-4 font-[Playfair Display] text-3xl font-bold text-black italic">Visual Grammar</h2>

            <div class="mt-10 space-y-8">
                <label class="block group">
                    <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Aesthetic Prefix</span>
                    <textarea name="global_prompt_prefix" rows="4" class="w-full rounded-[24px] border border-black/[0.04] bg-[#faf9f6] px-6 py-5 text-[13px] font-medium leading-relaxed text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all" placeholder="Global framing for every generation...">{{ $config['global_prompt_prefix'] }}</textarea>
                </label>

                <label class="block group">
                    <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Quality Suffix</span>
                    <textarea name="global_prompt_suffix" rows="4" class="w-full rounded-[24px] border border-black/[0.04] bg-[#faf9f6] px-6 py-5 text-[13px] font-medium leading-relaxed text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all" placeholder="Global quality controls and realism settings...">{{ $config['global_prompt_suffix'] }}</textarea>
                </label>
            </div>
        </article>

        <!-- Revenue & Access -->
        <article class="rounded-[48px] border border-black/[0.03] bg-white p-10 shadow-xl shadow-black/[0.02]">
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Monetization</p>
            <h2 class="mt-4 font-[Playfair Display] text-3xl font-bold text-black italic">Financial Core</h2>

            <div class="mt-10 space-y-8">
                <label class="block group">
                    <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Amazon Affiliate Identity</span>
                    <input type="text" name="amazon_affiliate_tag" value="{{ $config['amazon_affiliate_tag'] }}" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none shadow-sm focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all" placeholder="homiqai-21">
                </label>

                <label class="block group">
                    <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Apple Shared Secret</span>
                    <input type="password" name="apple_shared_secret" value="{{ $config['apple_shared_secret'] }}" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none shadow-sm focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                </label>

                <label class="block group">
                    <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Google Play Package</span>
                    <input type="text" name="google_package_name" value="{{ $config['google_package_name'] }}" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none shadow-sm focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                </label>
            </div>
        </article>
    </section>

    <!-- Budget Tiers -->
    <section class="grid gap-10 xl:grid-cols-3">
        @php
            $budgetCards = [
                ['key' => 'low', 'label' => $config['budget_low_label'], 'min' => $config['budget_low_min'], 'max' => $config['budget_low_max'], 'prompt' => $config['budget_low_prompt']],
                ['key' => 'medium', 'label' => $config['budget_medium_label'], 'min' => $config['budget_medium_min'], 'max' => $config['budget_medium_max'], 'prompt' => $config['budget_medium_prompt']],
                ['key' => 'high', 'label' => $config['budget_high_label'], 'min' => $config['budget_high_min'], 'max' => $config['budget_high_max'], 'prompt' => $config['budget_high_prompt']],
            ];
        @endphp

        @foreach ($budgetCards as $budget)
            <article class="rounded-[48px] border border-black/[0.03] bg-white p-10 shadow-xl shadow-black/[0.02]">
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Budget Stratum</p>
                <h2 class="mt-4 font-[Playfair Display] text-3xl font-bold text-black italic">{{ ucfirst($budget['key']) }} Grade</h2>

                <div class="mt-10 space-y-8">
                    <label class="block group">
                        <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Tier Label</span>
                        <input type="text" name="budget_{{ $budget['key'] }}_label" value="{{ $budget['label'] }}" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                    </label>

                    <div class="grid gap-6 md:grid-cols-2">
                        <label class="block group">
                            <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Min Price</span>
                            <input type="number" min="0" name="budget_{{ $budget['key'] }}_min" value="{{ $budget['min'] }}" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                        </label>

                        <label class="block group">
                            <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#a89078] group-focus-within:text-black transition-colors">Max Price</span>
                            <input type="number" min="0" name="budget_{{ $budget['key'] }}_max" value="{{ $budget['max'] }}" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-4.5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                        </label>
                    </div>

                    <label class="block group">
                        <span class="mb-3 block text-[11px] font-bold uppercase tracking-[0.2em] text-[#7a8a6b] group-focus-within:text-black transition-colors">Grade Prompt Specifics</span>
                        <textarea name="budget_{{ $budget['key'] }}_prompt" rows="5" class="w-full rounded-[24px] border border-black/[0.04] bg-[#faf9f6] px-6 py-5 text-[13px] font-medium leading-relaxed text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">{{ $budget['prompt'] }}</textarea>
                    </label>
                </div>
            </article>
        @endforeach
    </section>

    <!-- Advanced System Controls -->
    <section class="rounded-[56px] border border-black/[0.03] bg-white p-12 shadow-2xl shadow-black/[0.03]">
        <div class="flex flex-col gap-8 border-b border-black/[0.03] pb-10 xl:flex-row xl:items-center xl:justify-between">
            <div>
                <h2 class="font-[Playfair Display] text-4xl font-bold text-black italic">System Command</h2>
                <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#7a8a6b]">Advanced infrastructure overrides</p>
            </div>
            <button type="submit" class="rounded-[28px] bg-black px-12 py-5 text-[11px] font-bold uppercase tracking-[0.2em] text-white shadow-2xl transition-all hover:scale-105 active:scale-95">Deploy System Updates</button>
        </div>

        <div class="mt-12 grid gap-12 xl:grid-cols-2">
            <div class="space-y-10">
                <div class="grid gap-10 md:grid-cols-2">
                    <label class="block group">
                        <span class="mb-4 block text-[11px] font-bold uppercase tracking-[0.3em] text-[#8c4343] group-focus-within:text-black transition-colors">Maintenance Protocol</span>
                        <select name="maintenance_mode" id="maintenance_mode" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-5 text-[14px] font-bold text-black outline-none appearance-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                            <option value="0" {{ ($config['maintenance_mode'] ?? '0') == '0' ? 'selected' : '' }}>Operational (Live)</option>
                            <option value="1" {{ ($config['maintenance_mode'] ?? '0') == '1' ? 'selected' : '' }}>Restricted (Shielded)</option>
                        </select>
                    </label>

                    <label class="block group">
                        <span class="mb-4 block text-[11px] font-bold uppercase tracking-[0.3em] text-[#a89078] group-focus-within:text-black transition-colors">Manifest Version</span>
                        <input type="text" name="app_version" value="{{ $config['app_version'] ?? '1.0.0' }}" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                    </label>
                </div>

                <div class="grid gap-10 md:grid-cols-2">
                    <label class="block group">
                        <span class="mb-4 block text-[11px] font-bold uppercase tracking-[0.3em] text-[#a89078] group-focus-within:text-black transition-colors">Max Payload (MB)</span>
                        <input type="number" name="max_upload_size" value="{{ $config['max_upload_size'] }}" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                    </label>

                    <label class="block group">
                        <span class="mb-4 block text-[11px] font-bold uppercase tracking-[0.3em] text-[#a89078] group-focus-within:text-black transition-colors">Request Expiry (s)</span>
                        <input type="number" name="ai_timeout" value="{{ $config['ai_timeout'] }}" class="w-full rounded-[20px] border border-black/[0.04] bg-[#faf9f6] px-6 py-5 text-[14px] font-bold text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">
                    </label>
                </div>
            </div>

            <div class="space-y-10">
                <label class="block group">
                    <span class="mb-4 block text-[11px] font-bold uppercase tracking-[0.3em] text-[#a89078] group-focus-within:text-black transition-colors">Firebase Integration Manifest (JSON)</span>
                    <textarea name="firebase_config" rows="4" class="w-full rounded-[28px] border border-black/[0.04] bg-[#faf9f6] px-6 py-6 text-[13px] font-mono text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">{{ $config['firebase_config'] }}</textarea>
                </label>

                <label class="block group">
                    <span class="mb-4 block text-[11px] font-bold uppercase tracking-[0.3em] text-[#a89078] group-focus-within:text-black transition-colors">SMTP Routing Configuration (JSON)</span>
                    <textarea name="smtp_config" rows="4" class="w-full rounded-[28px] border border-black/[0.04] bg-[#faf9f6] px-6 py-6 text-[13px] font-mono text-black outline-none focus:bg-white focus:ring-8 focus:ring-[#7a8a6b]/10 transition-all">{{ $config['smtp_config'] }}</textarea>
                </label>
            </div>
        </div>

        <div class="mt-16 grid gap-6 sm:grid-cols-2 xl:grid-cols-6 border-t border-black/[0.03] pt-12">
            @foreach([
                'Env' => strtoupper($system['environment']),
                'Debug' => $system['debug'] ? 'Active' : 'Silent',
                'Storage' => $system['storage_disk'],
                'Database' => $system['db_connection'],
                'Sync' => 'Stable',
                'Heartbeat' => $system['last_sync']
            ] as $label => $value)
            <div class="rounded-[24px] bg-[#faf9f6] p-6 border border-black/[0.02]">
                <p class="text-[9px] font-bold uppercase tracking-widest text-[#a89078]">{{ $label }}</p>
                <p class="mt-2 text-[13px] font-bold text-black">{{ $value }}</p>
            </div>
            @endforeach
        </div>
    </section>
</form>
@endsection

