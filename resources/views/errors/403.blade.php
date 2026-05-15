<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Dilarang | {{ config('app.name', 'Mulia Grup') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo-2.png') }}?v=2">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=DM+Mono:wght@500&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        (function () {
            const saved = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <style>
        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .error-card {
            max-width: 500px;
            width: 100%;
            text-align: center;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .error-code {
            font-size: 8rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--accent), var(--ps-orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.05em;
            font-family: 'DM Sans', sans-serif;
        }

        .error-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .error-description {
            color: var(--text-secondary);
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2.5rem;
        }

        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: var(--accent);
            color: #ffffff;
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 10px 15px -3px rgba(94, 80, 161, 0.3);
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(94, 80, 161, 0.4);
            filter: brightness(110%);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: var(--bg-surface);
            color: var(--text-secondary);
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
            border: 1px solid var(--border-strong);
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: var(--bg-elevated);
            color: var(--text-primary);
            border-color: var(--text-tertiary);
        }

        .brand-footer {
            position: absolute;
            bottom: 2rem;
            left: 0;
            right: 0;
            text-align: center;
        }

        .brand-logo {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            margin-bottom: 0.5rem;
        }

        .brand-text {
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--text-primary);
            letter-spacing: -0.03em;
        }

        .brand-copyright {
            font-size: 0.75rem;
            color: var(--text-tertiary);
            font-family: 'DM Mono', monospace;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body class="antialiased">
    <div class="error-page">
        <div class="error-card">
            <div class="error-code">403</div>
            <h1 class="error-title">Akses Dilarang</h1>
            <p class="error-description">
                Maaf, Anda tidak memiliki izin yang diperlukan untuk mengakses halaman ini. 
                Jika Anda merasa ini adalah kesalahan, silakan hubungi administrator sistem.
            </p>
            
            <div class="error-actions">
                <a href="{{ url()->previous() }}" class="btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <a href="/" class="btn-home">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Ke Beranda
                </a>
            </div>
        </div>

        <div class="brand-footer">
            <a href="/" class="brand-logo">
                <img src="/logo-2.png" alt="Logo" style="height: 40px; width: auto;">
                <span class="brand-text">{{ config('app.name', 'Mulia Grup') }}</span>
            </a>
            <div class="brand-copyright">
                &copy; 2026 Mulia Grup. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
