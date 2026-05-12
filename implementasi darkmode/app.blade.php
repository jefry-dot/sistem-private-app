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

            {{-- ── TOPBAR / NAVIGATION ──────────────────── --}}
            @include('layouts.navigation')

            {{-- ── PAGE HEADER SLOT (optional) ──────────── --}}
            @if (isset($header))
                <header style="background:var(--bg-surface);border-bottom:1px solid var(--border-subtle);padding:1rem 0;">
                    <div class="content-wrapper" style="padding:0 1.5rem;">
                        <p class="section-label" style="margin-bottom:0.25rem;">Halaman</p>
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

        {{-- ── FOOTER ────────────────────────────────────── --}}
        <footer class="app-footer">
            <p>{!! get_setting('footer_text', 'Copyright &copy; 2026 <strong>' . config('app.name') . '</strong>') !!}</p>
        </footer>

        @stack('scripts')
    </body>
</html>
