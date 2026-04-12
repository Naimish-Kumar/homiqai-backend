<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homiq Admin Dashboard</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        :root {
            --bg-primary: #020617; /* Even darker for dashboard */
            --bg-secondary: #0F172A;
            --brand-teal: #49A9B4;
            --brand-teal-glow: rgba(73, 169, 180, 0.2);
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: white;
            overflow: hidden;
        }

        .glass {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
        }

        .sidebar-item {
            transition: all 0.3s ease;
        }

        .sidebar-item.active {
            background: rgba(73, 169, 180, 0.1);
            border-right: 3px solid var(--brand-teal);
            color: var(--brand-teal);
        }

        .sidebar-item:hover:not(.active) {
            background: rgba(255, 255, 255, 0.05);
        }

        .card-glow {
            box-shadow: 0 0 40px var(--brand-teal-glow);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
        }
    </style>
</head>
<body class="antialiased flex h-screen">
    
    <!-- Sidebar -->
    <aside class="w-72 h-full glass border-r border-white/5 flex flex-col pt-10">
        <div class="px-8 flex items-center gap-3 mb-12">
            <div class="w-8 h-8 bg-[#49A9B4] rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </div>
            <span class="text-xl font-black tracking-tighter outfit uppercase">Admin <span class="text-[#49A9B4]">Portal</span></span>
        </div>

        <nav class="flex-1 space-y-2 px-4">
            <a href="/admin" class="sidebar-item {{ Request::is('admin') ? 'active' : '' }} flex items-center gap-4 px-6 py-4 rounded-xl text-sm font-bold uppercase tracking-wider">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Overview
            </a>
            <a href="/admin/users" class="sidebar-item {{ Request::is('admin/users') ? 'active' : '' }} flex items-center gap-4 px-6 py-4 rounded-xl text-sm font-bold uppercase tracking-wider">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Users
            </a>
            <a href="/admin/subscriptions" class="sidebar-item {{ Request::is('admin/subscriptions') ? 'active' : '' }} flex items-center gap-4 px-6 py-4 rounded-xl text-sm font-bold uppercase tracking-wider">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Subscriptions
            </a>
            <a href="/admin/settings" class="sidebar-item {{ Request::is('admin/settings') ? 'active' : '' }} flex items-center gap-4 px-6 py-4 rounded-xl text-sm font-bold uppercase tracking-wider">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Config
            </a>
        </nav>

        <div class="p-4">
            <a href="/" class="flex items-center gap-4 px-6 py-4 rounded-xl text-sm font-bold uppercase tracking-wider text-white/40 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Web
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 h-full overflow-y-auto p-12">
        <header class="flex justify-between items-center mb-12">
            <div>
                <h1 class="text-4xl font-black outfit uppercase tracking-tighter">@yield('page_title', 'Dashboard')</h1>
                <p class="text-white/40 font-medium uppercase text-[10px] tracking-[0.3em] mt-1">Platform Management Interface</p>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Notifications Dummy -->
                <div class="w-12 h-12 glass rounded-2xl flex items-center justify-center relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-3 right-3 w-2 h-2 bg-[#49A9B4] rounded-full teal-glow"></span>
                </div>
                
                <div class="flex items-center gap-4 pl-6 border-l border-white/5">
                    <div class="text-right">
                        <div class="text-sm font-bold">Admin User</div>
                        <div class="text-[10px] font-black text-[#49A9B4] tracking-widest uppercase">Root Access</div>
                    </div>
                    <div class="w-12 h-12 bg-[#49A9B4]/10 rounded-2xl flex items-center justify-center border border-[#49A9B4]/20">
                        <svg class="w-6 h-6 text-[#49A9B4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                </div>
            </div>
        </header>

        @yield('admin_content')
    </div>

</body>
</html>
