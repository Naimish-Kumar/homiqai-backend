<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homiq Admin | @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/modern.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Homiq AI" style="filter: brightness(1.2);">
                <span>Management</span>
            </a>

            <nav class="admin-nav">
                <p class="sidebar-label">Analytics</p>
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie" style="width: 20px;"></i>
                    <span>Insights</span>
                </a>
                <p class="sidebar-label">Resources</p>
                <a href="{{ route('admin.users') }}" class="admin-nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-shield" style="width: 20px;"></i>
                    <span>Users</span>
                </a>
                <a href="{{ route('admin.designs') }}" class="admin-nav-link {{ request()->routeIs('admin.designs') ? 'active' : '' }}">
                    <i class="fa-solid fa-wand-magic-sparkles" style="width: 20px;"></i>
                    <span>Gallery</span>
                </a>
                <a href="{{ route('admin.styles') }}" class="admin-nav-link {{ request()->routeIs('admin.styles') ? 'active' : '' }}">
                    <i class="fa-solid fa-swatchbook" style="width: 20px;"></i>
                    <span>Library</span>
                </a>
                <p class="sidebar-label">Operations</p>
                <a href="{{ route('admin.subscriptions') }}" class="admin-nav-link {{ request()->routeIs('admin.subscriptions') ? 'active' : '' }}">
                    <i class="fa-solid fa-gem" style="width: 20px;"></i>
                    <span>Premium</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="admin-nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="fa-solid fa-sliders" style="width: 20px;"></i>
                    <span>Config</span>
                </a>
            </nav>

            <div class="admin-sidebar-footer">
                <a href="{{ route('home') }}" class="admin-secondary-link">Back to website</a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="admin-logout">Sign out</button>
                </form>
            </div>
        </aside>

        <main class="admin-main">
            <header class="admin-topbar">
                <div>
                    <p class="eyebrow">Homiq Operations</p>
                    <h1>@yield('title', 'Dashboard')</h1>
                </div>
                <div class="admin-profile">
                    <div>
                        <strong>{{ auth()->user()->name }}</strong>
                        <span>{{ auth()->user()->email }}</span>
                    </div>
                    <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                </div>
            </header>

            @if (session('status'))
                <div class="notice success">{{ session('status') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
