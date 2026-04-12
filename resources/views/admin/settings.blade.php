@extends('admin.layout')

@section('title', 'SYSTEM SETTINGS')

@section('content')
<div class="animate-fade">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
        
        <!-- API Credentials -->
        <div>
            <div style="margin-bottom: 30px;">
                <h2 class="font-heading" style="font-size: 28px;">API Credentials</h2>
                <p style="color: var(--text-secondary); font-size: 14px;">Manage secure keys for third-party AI and billing services.</p>
            </div>

            <div class="glass-card" style="padding: 30px; display: flex; flex-direction: column; gap: 24px;">
                <form action="#" method="POST">
                    @csrf
                    @foreach($credentials as $key => $value)
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 10px; letter-spacing: 1px;">
                            {{ str_replace('_', ' ', strtoupper($key)) }}
                        </label>
                        <div class="glass" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px;">
                            <input type="password" name="{{ $key }}" value="{{ $value }}" style="background: transparent; border: none; color: white; width: 100%; font-family: monospace; font-size: 14px; outline: none;">
                            <button type="submit" style="background: transparent; border: none; color: var(--neon-blue); cursor: pointer; font-size: 12px; font-weight: 700;">UPDATE</button>
                        </div>
                    </div>
                    @endforeach
                </form>

                <div style="margin-top: 10px; padding: 15px; background: rgba(255, 183, 3, 0.05); border-radius: 8px; border: 1px solid rgba(255, 183, 3, 0.1);">
                    <div style="font-size: 12px; color: #ffb703; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        REVOLUTIONARY ENCRYPTION ENABLED
                    </div>
                    <p style="font-size: 11px; color: var(--text-secondary); margin-top: 5px;">All keys are encrypted at rest with AES-256 for maximum security.</p>
                </div>
            </div>
        </div>

        <!-- Global Defaults -->
        <div>
            <div style="margin-bottom: 30px;">
                <h2 class="font-heading" style="font-size: 28px;">AI Service Control</h2>
                <p style="color: var(--text-secondary); font-size: 14px;">Modify global behavior and model parameters.</p>
            </div>

            <div class="glass-card" style="padding: 30px;">
                <h4 style="font-size: 14px; margin-bottom: 20px;">Primary Transformation Model</h4>
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <button class="glass" style="padding: 15px; display: flex; justify-content: space-between; border-color: var(--neon-blue); text-align: left;">
                        <div>
                            <div style="font-weight: 700; color: white;">Stable Diffusion XL v1.0</div>
                            <div style="font-size: 11px; color: var(--text-secondary);">Current Active Model (High Depth Precision)</div>
                        </div>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--neon-blue)" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </button>
                    <button class="glass" style="padding: 15px; display: flex; justify-content: space-between; text-align: left;">
                        <div>
                            <div style="font-weight: 700; color: white;">Homiq Custom Flux-1</div>
                            <div style="font-size: 11px; color: var(--text-secondary);">Experimental (Vibrant Color Science)</div>
                        </div>
                    </button>
                </div>

                <div style="margin-top: 40px;">
                    <h4 style="font-size: 14px; margin-bottom: 20px;">Maintenance & Access</h4>
                    <div class="glass" style="padding: 20px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-weight: 700;">Service Mode</div>
                            <div style="font-size: 12px; color: var(--text-secondary);">Currently: <strong>PUBLIC</strong></div>
                        </div>
                        <div style="width: 44px; height: 24px; background: var(--success); border-radius: 12px; position: relative;">
                            <div style="width: 18px; height: 18px; background: white; border-radius: 50%; position: absolute; right: 3px; top: 3px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
