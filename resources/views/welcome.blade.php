<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ get_setting('site_name', config('app.name', 'Mulia Grup')) }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('logo-2.png') }}?v=2">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                body {
                    font-family: 'Instrument Sans', sans-serif;
                    background-color: #FDFDFC;
                    color: #1b1b18;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    min-height: screen;
                    padding: 2rem;
                    margin: 0;
                }
                .container {
                    max-width: 600px;
                    width: 100%;
                    text-align: center;
                    background: white;
                    padding: 3rem;
                    border-radius: 12px;
                    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
                }
                h1 { font-size: 2rem; margin-bottom: 1rem; }
                p { color: #706f6c; margin-bottom: 2rem; }
                .btn {
                    display: inline-block;
                    padding: 0.75rem 1.5rem;
                    background-color: #5e50a1;
                    color: white;
                    text-decoration: none;
                    border-radius: 6px;
                    font-weight: 600;
                    transition: background 0.2s;
                }
                .btn:hover { background-color: #4c3f8a; }
                .logo { width: 120px; margin-bottom: 2rem; }
            </style>
        @endif
    </head>
    <body class="welcome-page flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <div class="welcome-card max-w-md w-full bg-surface p-8 rounded-2xl shadow-xl border border-subtle text-center" style="background: var(--bg-surface); border: 1px solid var(--border-subtle);">
            <img src="{{ get_setting('site_logo', '/logo-2.png') }}" alt="{{ get_setting('site_name', 'Mulia Grup') }} Logo" class="mx-auto h-20 mb-8">
            
            <h1 class="text-3xl font-bold mb-4 text-primary" style="color: var(--text-primary);">{{ get_setting('site_name', 'Mulia Grup') }}</h1>
            <h2 class="text-xl font-semibold mb-6 text-secondary tracking-tight" style="color: var(--text-secondary);">Sistem Manajemen Privat</h2>
            
            <p class="text-tertiary mb-10 leading-relaxed" style="color: var(--text-tertiary);">
                Selamat datang di sistem internal kami yang aman. Platform ini dikhususkan hanya untuk personel resmi Mulia Grup.
            </p>

            @if (Route::has('login'))
                <div class="space-y-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block w-full py-4 bg-[#5e50a1] hover:bg-[#4c3f8a] text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full py-4 bg-[#15803d] hover:bg-[#166534] text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Login - Masuk Akun
                        </a>
                        
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block w-full py-4 text-[#5e50a1] font-bold hover:underline">
                                Minta Akses Klien
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        
        <footer class="mt-12 text-center text-gray-400 text-sm">
            <p>&copy; 2026 Mulia Grup. Seluruh hak cipta dilindungi undang-undang.</p>
        </footer>
    </body>
</html>
