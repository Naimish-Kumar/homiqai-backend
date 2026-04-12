<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homiq Admin | @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/modern.css') }}">
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Homiq AI">
                <span>Admin</span>
            </a>

            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span>Overview</span>
                </a>
                <a href="{{ route('admin.users') }}" class="admin-nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <span>Users</span>
                </a>
                <a href="{{ route('admin.subscriptions') }}" class="admin-nav-link {{ request()->routeIs('admin.subscriptions') ? 'active' : '' }}">
                    <span>Revenue</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="admin-nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <span>Settings</span>
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
