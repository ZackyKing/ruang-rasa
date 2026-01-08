<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="RuangRasa - Ruang tenang untuk memahami kehidupan">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RuangRasa')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/post-interactions.css') }}">
    <link rel="stylesheet" href="{{ asset('css/create-post.css') }}">
    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">RuangRasa</a>

        <div class="navbar-center">
            <ul class="navbar-nav">
                <li>
                    <a href="{{ route('home') }}" class="nav-link" title="Beranda">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span class="nav-text">Beranda</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pertanyaan') }}" class="nav-link" title="Pertanyaan">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                        <span class="nav-text">Pertanyaan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('komunitas') }}" class="nav-link" title="Ruang">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <circle cx="19" cy="5" r="2"></circle>
                            <circle cx="5" cy="5" r="2"></circle>
                            <circle cx="19" cy="19" r="2"></circle>
                            <circle cx="5" cy="19" r="2"></circle>
                            <line x1="12" y1="9" x2="12" y2="3"></line>
                            <line x1="14.5" y1="13.5" x2="17" y2="17"></line>
                            <line x1="9.5" y1="13.5" x2="7" y2="17"></line>
                            <line x1="6.5" y1="6.5" x2="9.5" y2="10.5"></line>
                            <line x1="17.5" y1="6.5" x2="14.5" y2="10.5"></line>
                        </svg>
                        <span class="nav-text">Ruang</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('notifikasi') }}" class="nav-link" title="Notifikasi">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span class="nav-text">Notifikasi</span>
                    </a>
                </li>
            </ul>

            <form action="{{ route('search') }}" method="GET" class="navbar-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="q" placeholder="Cari...">
            </form>
        </div>

        <a href="{{ route('profil') }}" class="navbar-profile" title="Profil">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
        </a>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <script src="{{ asset('js/interactions.js') }}"></script>
    @stack('scripts')
</body>

</html>