<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Mulia Grup') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased" style="background: url('/bg.png') repeat;">
        <div class="min-h-screen flex flex-col">
            <header class="bg-white shadow" style="border-bottom: 2px solid #ddd; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-center items-center">
                        <h1 class="flex items-center text-2xl text-gray-800 font-bold m-0">
                            <a href="/"><img src="/logo-2.png" width="100" height="70" alt="Logo" class="mr-4"></a>
                            {{ config('app.name', 'Mulia Grup') }}
                        </h1>
                    </div>
                </div>
            </header>

            <div class="flex-1 flex flex-col items-center justify-center p-6">
                <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-lg overflow-hidden sm:rounded-lg border border-gray-200" style="border-radius: 8px;">
                    {{ $slot }}
                </div>
            </div>

            <div class="text-center py-4 bg-white/80 border-t border-gray-200">
                <p style="color:#093; margin: 0;"><b>Copyright &copy; CS_Team@MGF 2017</b></p>
            </div>
        </div>
    </body>
</html>