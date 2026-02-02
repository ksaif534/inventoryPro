<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventory Management') }} - @yield('title', 'Login')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @if(app()->environment('testing'))
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
        <script src="{{ asset('js/admin.js') }}"></script>
    @else
        @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @endif
</head>
<body class="h-full bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
    <!-- Logo at Top -->
    <div class="absolute top-8 left-0 right-0 flex justify-center">
        <x-inventory-logo />
    </div>

    <div class="min-h-screen flex items-start justify-center px-4 pt-20 sm:pt-24">
        <div class="w-full max-w-md sm:max-w-lg">
            <!-- Session Status -->
            <x-auth-session-status class="mb-6" :status="session('status')" />

            <!-- Main Content Card -->
            <div class="glass-card p-8 border-2 border-white/20">
                @yield('content')
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-gray-400 text-sm">
                    © {{ date('Y') }} {{ config('app.name', 'Inventory Management') }}. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>