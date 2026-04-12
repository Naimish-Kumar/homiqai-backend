<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Homiq AI</title>
    <link rel="stylesheet" href="{{ asset('css/modern.css') }}">
</head>
<body class="login-body">
    <main class="login-shell">
        <section class="login-visual">
            <img src="{{ asset('images/hero-studio.png') }}" alt="Modern interior studio">
            <div>
                <p class="eyebrow">Secure admin access</p>
                <h1>Manage Homiq with clarity and control.</h1>
                <p>Track users, designs, revenue signals, styles, and system readiness from one focused workspace.</p>
            </div>
        </section>

        <section class="login-panel">
            <a href="{{ route('home') }}" class="admin-secondary-link">Back to website</a>
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Homiq AI" class="login-logo">
                <h2>Admin sign in</h2>
                <p>Only approved administrators can enter the dashboard.</p>
            </div>

            <form action="{{ route('admin.login.store') }}" method="POST" class="login-form">
                @csrf
                <label>
                    <span>Email address</span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password" required>
                </label>
                <label class="remember-row">
                    <input type="checkbox" name="remember" value="1">
                    <span>Keep me signed in</span>
                </label>
                @if ($errors->any())
                    <div class="notice danger">{{ $errors->first() }}</div>
                @endif
                <button type="submit">Sign in securely</button>
            </form>
        </section>
    </main>
</body>
</html>
