<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" id="html-root">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ get_setting('site_name', config('app.name', 'Mulia Grup')) }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('logo-2.png') }}?v=2">

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
                const html = document.documentElement;
                const saved = localStorage.getItem('theme');
                const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

                function applyTheme(theme) {
                    if (theme === 'dark') {
                        html.classList.add('dark');
                    } else {
                        html.classList.remove('dark');
                    }
                }

                // Initial apply
                if (saved === 'dark' || (!saved && mediaQuery.matches)) {
                    applyTheme('dark');
                } else {
                    applyTheme('light');
                }

                // Listen for system changes
                mediaQuery.addEventListener('change', (e) => {
                    if (!localStorage.getItem('theme')) {
                        applyTheme(e.matches ? 'dark' : 'light');
                    }
                });

                // Global toggle handler
                document.addEventListener('DOMContentLoaded', () => {
                    document.addEventListener('click', (e) => {
                        const toggle = e.target.closest('.theme-toggle');
                        if (toggle) {
                            const isDark = html.classList.toggle('dark');
                            localStorage.setItem('theme', isDark ? 'dark' : 'light');
                        }
                    });
                });
            })();
        </script>
    </head>

    <body class="antialiased" x-data="{ sidebarOpen: false, mobileMenuOpen: false }">
        <div class="app-shell">

            @if(Auth::check() && Auth::user()->role === 'admin')
                {{-- ── SIDEBAR (Admin Only) ────────────────── --}}
                <div id="adminSidebar" class="admin-sidebar-wrapper">
                    @include('layouts.sidebar')
                </div>

                {{-- Mobile Sidebar Overlay --}}
                <div id="adminSidebarOverlay"
                     class="admin-sidebar-overlay fixed inset-0 bg-black/50 z-[90] lg:hidden">
                </div>

                <div class="main-content">
                    {{-- ── TOP HEADER (Responsive Style) ── --}}
                    <header class="top-header admin-top-header">
                        <div class="admin-top-left">
                            <button type="button" id="adminMenuToggle" class="admin-menu-toggle lg:hidden" aria-label="Buka menu admin" aria-controls="adminSidebar" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>

                        <div class="admin-top-actions">
                            {{-- Theme Toggle --}}
                            <button class="theme-toggle" id="themeToggleAdmin" title="Ganti Tema">
                                <svg class="icon-moon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                                </svg>
                                <svg class="icon-sun" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 7a5 5 0 100 10A5 5 0 0012 7z"/>
                                </svg>
                            </button>

                            <div class="admin-user-actions text-[13px] font-medium text-secondary">
                                <span class="admin-user-name hover:text-primary cursor-pointer">{{ Auth::user()->name }}</span>
                                
                                <a href="{{ route('profile.edit') }}" class="admin-top-link hover:text-primary cursor-pointer text-secondary no-underline" aria-label="Akun Saya">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Akun Saya</span>
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="admin-top-link hover:text-primary cursor-pointer border-0 bg-transparent text-secondary text-[13px] font-medium" aria-label="Keluar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </header>

                    <x-toast />

                    <main class="app-content">
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

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const sidebar = document.getElementById('adminSidebar');
                const overlay = document.getElementById('adminSidebarOverlay');
                const toggle = document.getElementById('adminMenuToggle');

                if (!sidebar || !overlay || !toggle) return;

                const setOpen = (isOpen) => {
                    sidebar.classList.toggle('open', isOpen);
                    overlay.classList.toggle('is-open', isOpen);
                    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                };

                toggle.addEventListener('click', () => setOpen(!sidebar.classList.contains('open')));
                overlay.addEventListener('click', () => setOpen(false));
            });
        </script>

        @stack('scripts')
    </body>
</html>
