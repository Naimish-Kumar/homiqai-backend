@extends('admin.layout')

@section('title', 'System Settings')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" class="settings-form">
    @csrf
    
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <section class="dashboard-grid">
        <!-- AI Configuration -->
        <div class="panel">
            <div class="panel-header">
                <div>
                    <p class="eyebrow">Artificial Intelligence</p>
                    <h2>Provider Settings</h2>
                </div>
            </div>
            
            <div class="field-group">
                <label for="ai_provider">Primary AI Provider</label>
                <select name="ai_provider" id="ai_provider" class="form-control">
                    <option value="stability" {{ $config['ai_provider'] == 'stability' ? 'selected' : '' }}>Stability AI (SD3)</option>
                    <option value="openai" {{ $config['ai_provider'] == 'openai' ? 'selected' : '' }}>OpenAI (DALL-E 3)</option>
                </select>
                <small>Determines which engine generates the final room designs.</small>
            </div>

            <div class="field-group">
                <label for="stability_ai_key">Stability AI API Key</label>
                <input type="password" name="stability_ai_key" id="stability_ai_key" value="{{ $config['stability_ai_key'] }}" class="form-control" placeholder="sk-...">
            </div>

            <div class="field-group">
                <label for="openai_key">OpenAI API Key</label>
                <input type="password" name="openai_key" id="openai_key" value="{{ $config['openai_key'] }}" class="form-control" placeholder="sk-...">
            </div>
        </div>

        <!-- Revenue & Integration -->
        <div class="panel">
            <div class="panel-header">
                <div>
                    <p class="eyebrow">Monetization</p>
                    <h2>Affiliate & Store</h2>
                </div>
            </div>

            <div class="field-group">
                <label for="amazon_affiliate_tag">Amazon India Affiliate Tag</label>
                <input type="text" name="amazon_affiliate_tag" id="amazon_affiliate_tag" value="{{ $config['amazon_affiliate_tag'] }}" class="form-control" placeholder="homiqai-21">
                <small>Used for all furniture purchase recommendations.</small>
            </div>

            <div class="field-group">
                <label for="apple_shared_secret">Apple Shared Secret</label>
                <input type="password" name="apple_shared_secret" id="apple_shared_secret" value="{{ $config['apple_shared_secret'] }}" class="form-control">
                <small>Required for iOS receipt verification.</small>
            </div>

            <div class="field-group">
                <label for="google_package_name">Google Play Package Name</label>
                <input type="text" name="google_package_name" id="google_package_name" value="{{ $config['google_package_name'] }}" class="form-control">
            </div>
        </div>

        <!-- System Controls -->
        <div class="panel">
            <div class="panel-header">
                <div>
                    <p class="eyebrow">System</p>
                    <h2>Advanced Controls</h2>
                </div>
            </div>

            <div class="field-group">
                <label for="maintenance_mode">Maintenance Mode</label>
                <select name="maintenance_mode" id="maintenance_mode" class="form-control">
                    <option value="0" {{ ($config['maintenance_mode'] ?? '0') == '0' ? 'selected' : '' }}>Off (Public)</option>
                    <option value="1" {{ ($config['maintenance_mode'] ?? '0') == '1' ? 'selected' : '' }}>On (Restricted Access)</option>
                </select>
            </div>

            <div class="field-group">
                <label for="app_version">Current App Version</label>
                <input type="text" name="app_version" id="app_version" value="{{ $config['app_version'] ?? '1.0.0' }}" class="form-control">
                <small>Displayed in app and used for update prompts.</small>
            </div>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div>
                <p class="eyebrow">Status</p>
                <h2>Environment & Health</h2>
            </div>
            <button type="submit" class="btn btn-primary">Save All Changes</button>
        </div>
        
        <div class="status-list grid-3">
            <div><span>Environment</span><strong>{{ strtoupper($system['environment']) }}</strong></div>
            <div><span>Debug Mode</span><strong>{{ $system['debug'] }}</strong></div>
            <div><span>Storage</span><strong>{{ $system['storage_disk'] }}</strong></div>
            <div><span>DB Driver</span><strong>{{ $system['db_connection'] }}</strong></div>
            <div><span>Config Status</span><strong>Live (DB Override)</strong></div>
            <div><span>Last Sync</span><strong>{{ $system['last_sync'] }}</strong></div>
        </div>
    </section>
</form>

<style>
    .settings-form .field-group { margin-bottom: 1.5rem; }
    .settings-form label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151; }
    .settings-form .form-control { width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; background: #f9fafb; transition: all 0.2s; }
    .settings-form .form-control:focus { border-color: #4f46e5; outline: none; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
    .settings-form small { color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem; display: block; }
    .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
    .alert { padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; }
    .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #10b981; }
    .btn-primary { background: #4f46e5; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; border: none; font-weight: 600; cursor: pointer; }
    .btn-primary:hover { background: #4338ca; }
</style>
@endsection

