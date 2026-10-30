<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SiagaBanjir') - Sistem Laporan Banjir</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="bg-waves"></div>

<header class="nav">
    <a href="/" class="brand"><span class="drop"></span> LaporBanjir</a>
    <nav class="menu">
        <a href="{{ route('lapor.create') }}" class="{{ request()->routeIs('lapor.*') ? 'active' : '' }}">Lapor Banjir</a>

        @auth
            <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">Daftar Laporan</a>
            <a href="{{ route('profil') }}" class="{{ request()->routeIs('profil') ? 'active' : '' }}">Profil Petugas</a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn-link">Logout</button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
            <a href="{{ route('register') }}" class="btn-nav">Register</a>
        @endguest
    </nav>
</header>

<main class="container">
    @if (session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    @yield('content')
</main>

<footer class="footer">© {{ date('Y') }} SiagaBanjir · Sistem Pelaporan Banjir BPBD</footer>
</body>
</html>
