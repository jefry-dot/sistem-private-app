<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" id="html-root">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ get_setting('site_name', config('app.name', 'Private File Sharing')) }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ get_setting('site_favicon', '/favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{--
            Dark mode init script — runs BEFORE paint to avoid flash of wrong theme.
            Must be inline here, not in app.js.
        --}}
        <script>
            (function () {
                const saved = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (saved === 'dark' || (!saved && prefersDark)) {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>
    </head>

    <body class="antialiased" x-data="{ mobileMenuOpen: false }">
        <div class="app-shell">

            @if(Auth::check() && Auth::user()->role === 'admin')
                {{-- ── SIDEBAR (Admin Only) ────────────────── --}}
                @include('layouts.sidebar')

                <div class="main-content">
                    {{-- ── TOP HEADER (Dark ProjectSend Style) ── --}}
                    <header class="top-header" style="height: 64px; display: flex; align-items: center; justify-content: flex-end; padding: 0 1.5rem; background: var(--topbar-bg); border: none;">
                        <div class="flex items-center gap-6 text-[13px] font-medium text-white/90">
                            <span class="hover:text-white cursor-pointer">{{ Auth::user()->name }}</span>
                            
                            <div class="flex items-center gap-1 hover:text-white cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                Language
                                <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M19 9l-7 7-7-7"/></svg>
                            </div>

                            <div class="flex items-center gap-1 hover:text-white cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                My Account
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-1 hover:text-white cursor-pointer border-0 bg-transparent text-white/90 text-[13px] font-medium p-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </header>

                    <x-toast />

                    <main class="app-content" style="padding: 2rem; background: #f4f7f6;">
                        <div class="content-wrapper" style="max-width: 100%;">
                            {{ $slot }}
                        </div>
                    </main>
                </div>
            @else
                <div class="flex flex-col w-full">
                    <x-toast />

                    {{-- ── TOPBAR / NAVIGATION ──────────────────── --}}
                    @include('layouts.navigation')

                    {{-- ── PAGE HEADER SLOT (optional) ──────────── --}}
                    @if (isset($header))
                        <header style="background:var(--bg-surface);border-bottom:1px solid var(--border-subtle);padding:1rem 0;">
                            <div class="content-wrapper" style="padding:0 1.5rem;">
                                <h2 style="font-size:1.25rem;font-weight:700;letter-spacing:-0.03em;color:var(--text-primary);margin:0;">
                                    {{ $header }}
                                </h2>
                            </div>
                        </header>
                    @endif

                    {{-- ── MAIN CONTENT ──────────────────────────── --}}
                    <main class="app-content">
                        <div class="content-wrapper">
                            {{ $slot }}
                        </div>
                    </main>
                </div>
            @endif

        </div>

        {{-- ── FOOTER ────────────────────────────────────── --}}
        <footer class="app-footer">
            <p>{!! get_setting('footer_text', 'Copyright &copy; 2026 <strong>' . config('app.name') . '</strong>') !!}</p>
        </footer>

        @stack('scripts')
    </body>
</html>