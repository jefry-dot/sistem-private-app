{{--
    resources/views/layouts/navigation.blade.php
--}}

<style>
    /* ── MINIMALIST TOPBAR ──────────────── */
    .topbar {
        position: sticky;
        top: 0;
        z-index: 100;
        padding: 0.25rem 1rem 0;
    }

    .topbar-shell {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        display: flex;
        align-items: center;
        justify-content: flex-end; /* Paksa ke kanan */
        padding: 0.875rem 1rem;
    }

    /* ── USER DROPDOWN ────────────────── */
    .user-dropdown-container {
        position: relative;
    }

    .topbar-user {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0.75rem;
        border-radius: 12px;
        background: var(--bg-surface);
        border: 1px solid var(--border-subtle);
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .topbar-user:hover {
        border-color: var(--accent-muted);
        transform: translateY(-1px);
    }

    .user-dropdown-menu {
        position: absolute;
        right: 0;
        top: calc(100% + 10px);
        width: 240px;
        background: var(--bg-surface);
        border: 1px solid var(--border-strong);
        border-radius: 16px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        padding: 0.5rem;
        z-index: 110;
        opacity: 0;
        transform: translateY(-5px) scale(0.98);
        pointer-events: none;
        transition: all 0.2s ease;
    }

    .user-dropdown-container.open .user-dropdown-menu {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: auto;
    }

    .dropdown-user-header {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border-subtle);
        margin-bottom: 0.5rem;
    }

    .dropdown-item-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.625rem 0.875rem;
        border-radius: 10px;
        color: var(--text-secondary);
        font-size: 0.8125rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .dropdown-item-link:hover {
        background: var(--accent-light);
        color: var(--accent);
    }

    .dropdown-item-link.danger:hover {
        background: rgba(220, 38, 38, 0.08);
        color: var(--danger);
    }

    .topbar-user-name {
        font-size: 0.8125rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .theme-toggle {
        margin-right: 1rem;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        border: 1px solid var(--border-subtle);
        background: var(--bg-surface);
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.2s;
    }

    .theme-toggle:hover {
        border-color: var(--accent);
        color: var(--accent);
    }
</style>

<nav class="topbar">
    <div class="topbar-shell">
        
        {{-- Right Side Only --}}
        <div class="flex items-center">
            {{-- Theme Toggle --}}
            <button class="theme-toggle" id="themeToggle" title="Ganti Tema">
                <svg class="icon-moon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
                <svg class="icon-sun" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 7a5 5 0 100 10A5 5 0 0012 7z"/>
                </svg>
            </button>

            @auth
                {{-- Minimalist User Dropdown --}}
                <div class="user-dropdown-container" id="userDropdown">
                    <div class="topbar-user" onclick="toggleUserDropdown()">
                        <span class="topbar-user-name hidden sm:inline">{{ Auth::user()->name }}</span>
                        <svg class="text-tertiary" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>

                    <div class="user-dropdown-menu">
                        <div class="dropdown-user-header">
                            <p class="text-xs font-bold truncate m-0">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-tertiary truncate m-0">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <a href="{{ route('profile.edit') }}" class="dropdown-item-link">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil Saya
                        </a>
                        
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item-link">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                Dashboard Admin
                            </a>
                        @endif
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item-link danger w-full text-left border-0 bg-transparent cursor-pointer">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>

<script>
    function toggleUserDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('open');
    }

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown && !dropdown.contains(event.target)) {
            dropdown.classList.remove('open');
        }
    });
</script>
