@extends('admin.layout')

@section('title', 'System Settings')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
    @csrf

    <section class="grid gap-6 xl:grid-cols-3">
        <div class="rounded-[32px] border border-white/60 bg-white/72 p-6 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[var(--color-olive)]">Artificial Intelligence</p>
            <h2 class="mt-3 font-[var(--font-display)] text-3xl leading-tight">Provider settings</h2>

            <div class="mt-6 space-y-5">
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[var(--color-charcoal)]">Primary AI Provider</span>
                    <select name="ai_provider" id="ai_provider" class="w-full rounded-[18px] border border-[rgba(47,47,47,0.10)] bg-[rgba(247,246,242,0.84)] px-4 py-3 text-sm outline-none">
                        <option value="stability" {{ $config['ai_provider'] == 'stability' ? 'selected' : '' }}>Stability AI (SD3)</option>
                        <option value="openai" {{ $config['ai_provider'] == 'openai' ? 'selected' : '' }}>OpenAI (DALL-E 3)</option>
                    </select>
                    <span class="mt-2 block text-xs text-[color:rgba(47,47,47,0.52)]">Determines which engine generates the final room designs.</span>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[var(--color-charcoal)]">Stability AI API Key</span>
                    <input type="password" name="stability_ai_key" id="stability_ai_key" value="{{ $config['stability_ai_key'] }}" class="w-full rounded-[18px] border border-[rgba(47,47,47,0.10)] bg-[rgba(247,246,242,0.84)] px-4 py-3 text-sm outline-none" placeholder="sk-...">
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[var(--color-charcoal)]">OpenAI API Key</span>
                    <input type="password" name="openai_key" id="openai_key" value="{{ $config['openai_key'] }}" class="w-full rounded-[18px] border border-[rgba(47,47,47,0.10)] bg-[rgba(247,246,242,0.84)] px-4 py-3 text-sm outline-none" placeholder="sk-...">
                </label>
            </div>
        </div>

        <div class="rounded-[32px] border border-white/60 bg-white/72 p-6 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[var(--color-olive)]">Monetization</p>
            <h2 class="mt-3 font-[var(--font-display)] text-3xl leading-tight">Affiliate & store</h2>

            <div class="mt-6 space-y-5">
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[var(--color-charcoal)]">Amazon India Affiliate Tag</span>
                    <input type="text" name="amazon_affiliate_tag" id="amazon_affiliate_tag" value="{{ $config['amazon_affiliate_tag'] }}" class="w-full rounded-[18px] border border-[rgba(47,47,47,0.10)] bg-[rgba(247,246,242,0.84)] px-4 py-3 text-sm outline-none" placeholder="homiqai-21">
                    <span class="mt-2 block text-xs text-[color:rgba(47,47,47,0.52)]">Used for all furniture purchase recommendations.</span>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[var(--color-charcoal)]">Apple Shared Secret</span>
                    <input type="password" name="apple_shared_secret" id="apple_shared_secret" value="{{ $config['apple_shared_secret'] }}" class="w-full rounded-[18px] border border-[rgba(47,47,47,0.10)] bg-[rgba(247,246,242,0.84)] px-4 py-3 text-sm outline-none">
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[var(--color-charcoal)]">Google Play Package Name</span>
                    <input type="text" name="google_package_name" id="google_package_name" value="{{ $config['google_package_name'] }}" class="w-full rounded-[18px] border border-[rgba(47,47,47,0.10)] bg-[rgba(247,246,242,0.84)] px-4 py-3 text-sm outline-none">
                </label>
            </div>
        </div>

        <div class="rounded-[32px] border border-white/60 bg-white/72 p-6 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[var(--color-olive)]">System</p>
            <h2 class="mt-3 font-[var(--font-display)] text-3xl leading-tight">Advanced controls</h2>

            <div class="mt-6 space-y-5">
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[var(--color-charcoal)]">Maintenance Mode</span>
                    <select name="maintenance_mode" id="maintenance_mode" class="w-full rounded-[18px] border border-[rgba(47,47,47,0.10)] bg-[rgba(247,246,242,0.84)] px-4 py-3 text-sm outline-none">
                        <option value="0" {{ ($config['maintenance_mode'] ?? '0') == '0' ? 'selected' : '' }}>Off (Public)</option>
                        <option value="1" {{ ($config['maintenance_mode'] ?? '0') == '1' ? 'selected' : '' }}>On (Restricted Access)</option>
                    </select>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-[var(--color-charcoal)]">Current App Version</span>
                    <input type="text" name="app_version" id="app_version" value="{{ $config['app_version'] ?? '1.0.0' }}" class="w-full rounded-[18px] border border-[rgba(47,47,47,0.10)] bg-[rgba(247,246,242,0.84)] px-4 py-3 text-sm outline-none">
                    <span class="mt-2 block text-xs text-[color:rgba(47,47,47,0.52)]">Displayed in app and used for update prompts.</span>
                </label>
            </div>
        </div>
    </section>

    <section class="rounded-[32px] border border-white/60 bg-white/72 p-6 shadow-[0_22px_60px_rgba(47,47,47,0.07)] backdrop-blur-xl">
        <div class="flex flex-col gap-4 border-b border-[rgba(47,47,47,0.08)] pb-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.26em] text-[var(--color-olive)]">Status</p>
                <h2 class="mt-3 font-[var(--font-display)] text-3xl leading-tight">Environment & health</h2>
            </div>
            <button type="submit" class="rounded-full bg-[var(--color-charcoal)] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[var(--color-taupe)]">Save All Changes</button>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-[24px] bg-[rgba(247,246,242,0.82)] p-5"><p class="text-sm text-[color:rgba(47,47,47,0.56)]">Environment</p><p class="mt-2 text-xl font-semibold">{{ strtoupper($system['environment']) }}</p></div>
            <div class="rounded-[24px] bg-[rgba(247,246,242,0.82)] p-5"><p class="text-sm text-[color:rgba(47,47,47,0.56)]">Debug Mode</p><p class="mt-2 text-xl font-semibold">{{ $system['debug'] }}</p></div>
            <div class="rounded-[24px] bg-[rgba(247,246,242,0.82)] p-5"><p class="text-sm text-[color:rgba(47,47,47,0.56)]">Storage</p><p class="mt-2 text-xl font-semibold">{{ $system['storage_disk'] }}</p></div>
            <div class="rounded-[24px] bg-[rgba(247,246,242,0.82)] p-5"><p class="text-sm text-[color:rgba(47,47,47,0.56)]">DB Driver</p><p class="mt-2 text-xl font-semibold">{{ $system['db_connection'] }}</p></div>
            <div class="rounded-[24px] bg-[rgba(247,246,242,0.82)] p-5"><p class="text-sm text-[color:rgba(47,47,47,0.56)]">Config Status</p><p class="mt-2 text-xl font-semibold">Live (DB Override)</p></div>
            <div class="rounded-[24px] bg-[rgba(247,246,242,0.82)] p-5"><p class="text-sm text-[color:rgba(47,47,47,0.56)]">Last Sync</p><p class="mt-2 text-xl font-semibold">{{ $system['last_sync'] }}</p></div>
        </div>
    </section>
</form>
@endsection
