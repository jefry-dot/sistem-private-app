{{--
    resources/views/layouts/navigation.blade.php
--}}

@php
    $pendingCount = \App\Models\User::where('status', 'pending')->count();
@endphp

<style>
    /* ── OVERRIDE TOPBAR (SOLID DESIGN) ──────────────── */
    .topbar {
        position: sticky;
        top: 0;
        z-index: 100;
        padding: 0.75rem 1rem 0;
    }

    .topbar-shell {
        /* Menggunakan background solid dari variabel topbar */
        background: var(--topbar-bg) !important;
        backdrop-filter: blur(10px) !important;
        border: 1px solid var(--border-strong) !important;
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.1) !important;
        transition: all 0.3s ease;
    }

    html.dark .topbar-shell {
        background: var(--topbar-bg) !important;
        box-shadow: 0 10px 40px -10px rgba(0,0,0,0.4) !important;
    }

    /* ── NAV LINKS ────────────────────────────────────── */
    .topbar-link {
        transition: all 0.2s ease;
    }

    .topbar-link:hover {
        background: var(--accent-light) !important;
        transform: translateY(-1px);
    }

    .topbar-link.active {
        background: var(--accent) !important;
        color: #fff !important;
    }

    html.dark .topbar-link:not(.active) {
        color: var(--text-secondary) !important;
    }

    html.dark .topbar-link:not(.active):hover {
        color: var(--text-primary) !important;
    }

    /* ── USER DROPDOWN (RAIPH & SOLID) ────────────────── */
    .user-dropdown-container {
        position: relative;
    }

    .user-dropdown-menu {
        position: absolute;
        right: 0;
        top: calc(100% + 15px);
        width: 260px;
        background: var(--bg-surface) !important; /* Benar-benar solid */
        border: 1px solid var(--border-strong);
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        padding: 0.75rem;
        z-index: 110;
        opacity: 0;
        transform: translateY(-10px) scale(0.95);
        pointer-events: none;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    html.dark .user-dropdown-menu {
        background: var(--bg-elevated) !important;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }

    .user-dropdown-container.open .user-dropdown-menu {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: auto;
    }

    /* Header info di dalam dropdown */
    .dropdown-user-header {
        padding: 1rem;
        background: var(--accent-light);
        border-radius: 16px;
        margin-bottom: 0.75rem;
        border: 1px solid var(--accent-muted);
    }

    .dropdown-item-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        color: var(--text-secondary);
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s ease;
        margin-bottom: 2px;
    }

    .dropdown-item-link:hover {
        background: var(--bg-base);
        color: var(--accent);
        padding-left: 1.25rem;
    }

    .dropdown-item-link svg {
        width: 18px;
        height: 18px;
        opacity: 0.8;
    }

    .dropdown-item-link.danger:hover {
        background: rgba(220, 38, 38, 0.08);
        color: var(--danger);
    }

    /* Memastikan tombol user muncul di tablet juga */
    /* ── USER & THEME TOGGLE (NO BOX) ────────────────── */
    .topbar-user {
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
        gap: 0.5rem !important;
    }

    .topbar-user-avatar {
        display: none !important; /* Hilangkan avatar kotak */
    }

    .theme-toggle {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        width: auto !important;
        height: auto !important;
        padding: 0.5rem !important;
    }

    .topbar-user-name {
        font-size: 0.875rem !important;
        font-weight: 700 !important;
        color: var(--text-primary) !important;
    }

    .topbar-user-role {
        font-size: 0.65rem !important;
        font-weight: 600 !important;
        color: var(--text-tertiary) !important;
        margin-top: -2px !important;
    }

    .topbar-right {
        gap: 1.25rem !important;
    }
    </style>

<nav class="topbar">
    <div class="topbar-shell">
        {{-- Brand --}}
        <a href="{{ route('dashboard') }}" class="topbar-brand">
            <div class="topbar-brand-mark">
                <img src="{{ get_setting('site_logo', '/logo-2.png') }}" alt="Logo">
            </div>
            <div class="topbar-brand-copy hidden sm:flex">
                <span class="topbar-brand-title">{{ get_setting('site_name', config('app.name', 'Mulia Grup')) }}</span>
                <span class="topbar-brand-subtitle">Sistem Privat</span>
            </div>
        </a>

        {{-- Desktop Navigation --}}
        <div class="topbar-nav-panel">
            <div class="topbar-nav">
                <a href="{{ route('dashboard') }}" class="topbar-link {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('client.dashboard') ? 'active' : '' }}">
                    Beranda
                </a>

                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.file.index') }}" class="topbar-link {{ request()->routeIs('admin.file.*') ? 'active' : '' }}">
                        File
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="topbar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        Client
                        @if($pendingCount > 0)
                            <span class="topbar-link-badge">{{ $pendingCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.groups.index') }}" class="topbar-link {{ request()->routeIs('admin.groups.*') ? 'active' : '' }}">
                        Grup
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="topbar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        Pengaturan
                    </a>
                @endif
            </div>
        </div>

        {{-- Right Section --}}
        <div class="topbar-right">
            {{-- Theme Toggle --}}
            <button class="theme-toggle" id="themeToggle" title="Ganti Tema">
                <svg class="icon-moon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
                <svg class="icon-sun" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 7a5 5 0 100 10A5 5 0 0012 7z"/>
                </svg>
            </button>

            @auth
                {{-- User Dropdown --}}
                <div class="user-dropdown-container" id="userDropdown">
                    <div class="topbar-user cursor-pointer" onclick="toggleUserDropdown()">
                        <div class="topbar-user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="topbar-user-copy hidden lg:flex">
                            <span class="topbar-user-name">{{ Auth::user()->name }}</span>
                            <span class="topbar-user-role">{{ Auth::user()->role }}</span>
                        </div>
                        <svg class="ml-1 text-tertiary" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>

                    <div class="user-dropdown-menu">
                        <div class="dropdown-user-header">
                            <p class="text-sm font-bold truncate m-0" style="color:var(--accent)">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-secondary truncate m-0 opacity-70">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <a href="{{ route('profile.edit') }}" class="dropdown-item-link">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil Saya
                        </a>
                        
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.settings.index') }}" class="dropdown-item-link">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Pengaturan
                            </a>
                        @endif
                        
                        <div style="height: 1px; background: var(--border-subtle); margin: 0.5rem 0.25rem;"></div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item-link danger w-full text-left border-0 bg-transparent cursor-pointer">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

            {{-- Mobile Toggle --}}
            <button class="topbar-mobile-toggle" @click="mobileMenuOpen = !mobileMenuOpen">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</nav>

{{-- Mobile Navigation --}}
<div
    x-show="mobileMenuOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    class="mobile-nav"
    style="z-index: 150;"
>
    {{-- Konten mobile nav tetap sama namun dipastikan background pekat --}}
    <div class="mobile-nav-header">
        <h3 class="mobile-nav-title">Menu Utama</h3>
        @auth
            <div class="mobile-nav-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
        @endauth
    </div>
    {{-- ... (links) --}}
    <div class="mobile-nav-links">
        <a href="{{ route('dashboard') }}" class="mobile-nav-link {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('client.dashboard') ? 'active' : '' }}">Beranda</a>
        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('admin.file.index') }}" class="mobile-nav-link {{ request()->routeIs('admin.file.*') ? 'active' : '' }}">File</a>
            <a href="{{ route('admin.users.index') }}" class="mobile-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Client</a>
            <a href="{{ route('admin.settings.index') }}" class="mobile-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">Pengaturan</a>
        @endif
    </div>
    <div class="mobile-nav-footer">
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="mobile-nav-primary w-full">Keluar</button>
        </form>
    </div>
</div>

<script>
    function toggleUserDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('open');
    }

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        if (!dropdown) return;
        if (!dropdown.contains(event.target)) {
            dropdown.classList.remove('open');
        }
    });
</script>
