<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventory Management') }} - @yield('title', 'Admin')</title>

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
    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="h-full flex">
        <!-- Mobile sidebar overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 lg:hidden bg-black bg-opacity-50"
             @click="sidebarOpen = false">
        </div>

        <!-- Sidebar -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-transform ease-in-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition-transform ease-in-out duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 z-50 w-64 lg:static lg:inset-auto lg:translate-x-0 lg:block"
             :class="sidebarOpen ? 'block' : 'hidden lg:block'">
            
            <div class="flex flex-col h-full backdrop-blur-xl bg-white/10 border-r border-white/20">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 border-b border-white/20">
                    <h1 class="text-xl font-bold text-white">
                        {{ config('app.name', 'Inventory') }}
                    </h1>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-cyan-500/20 to-purple-500/20 text-cyan-400 border border-cyan-500/30' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.categories.index') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-cyan-500/20 to-purple-500/20 text-cyan-400 border border-cyan-500/30' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Categories
                    </a>

                    <a href="{{ route('admin.products.index') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-cyan-500/20 to-purple-500/20 text-cyan-400 border border-cyan-500/30' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Products
                    </a>

                    <a href="{{ route('admin.suppliers.index') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.suppliers.*') ? 'bg-gradient-to-r from-cyan-500/20 to-purple-500/20 text-cyan-400 border border-cyan-500/30' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Suppliers
                    </a>

                    <a href="{{ route('admin.purchase-orders.index') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.purchase-orders.*') ? 'bg-gradient-to-r from-cyan-500/20 to-purple-500/20 text-cyan-400 border border-cyan-500/30' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Purchase Orders
                    </a>

                    <a href="{{ route('admin.stock-movements.index') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.stock-movements.*') ? 'bg-gradient-to-r from-cyan-500/20 to-purple-500/20 text-cyan-400 border border-cyan-500/30' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                        Stock Movements
                    </a>

                    <div class="border-t border-white/20 pt-2 mt-2">
                        <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Reports</h3>
                        
                        <a href="{{ route('admin.reports.stock') }}" 
                           class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.reports.stock') ? 'bg-gradient-to-r from-cyan-500/20 to-purple-500/20 text-cyan-400 border border-cyan-500/30' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Stock Report
                        </a>

                        <a href="{{ route('admin.reports.low-stock') }}" 
                           class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.reports.low-stock') ? 'bg-gradient-to-r from-cyan-500/20 to-purple-500/20 text-cyan-400 border border-cyan-500/30' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.502 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            Low Stock Alert
                        </a>
                    </div>
                </nav>

                <!-- User Menu -->
                <div class="border-t border-white/20 p-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-cyan-500 to-purple-500 flex items-center justify-center">
                                <span class="text-white text-sm font-medium">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs text-gray-400 truncate">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-3 py-2 text-sm font-medium text-gray-300 rounded-lg hover:text-white hover:bg-white/10 transition-all duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top bar -->
            <header class="backdrop-blur-xl bg-white/10 border-b border-white/20">
                <div class="flex items-center justify-between px-4 py-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="flex items-center space-x-4">
                        <!-- Breadcrumb -->
                        <nav class="hidden md:flex items-center space-x-2 text-sm">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-white transition-colors">
                                Dashboard
                            </a>
                            @yield('breadcrumb')
                        </nav>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Flash messages -->
                        @if(session('success'))
                        <div class="hidden lg:flex items-center px-3 py-1.5 text-sm text-green-400 bg-green-500/10 border border-green-500/30 rounded-lg">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            {{ session('success') }}
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="hidden lg:flex items-center px-3 py-1.5 text-sm text-red-400 bg-red-500/10 border border-red-500/30 rounded-lg">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            {{ session('error') }}
                        </div>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-auto">
                <!-- Flash messages (mobile) -->
                @if(session('success'))
                <div class="lg:hidden mx-4 mt-4 flex items-center px-3 py-1.5 text-sm text-green-400 bg-green-500/10 border border-green-500/30 rounded-lg">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="lg:hidden mx-4 mt-4 flex items-center px-3 py-1.5 text-sm text-red-400 bg-red-500/10 border border-red-500/30 rounded-lg">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    {{ session('error') }}
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>