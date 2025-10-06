<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,900&display=swap" rel="stylesheet" />

    <!-- Tailwind & Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
        <div class="px-6 py-6 border-b border-gray-700">
            <h2 class="text-2xl font-bold">Admin</h2>
            <p class="text-sm text-gray-400">Dashboard Pengelolaan</p>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-2 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-4 py-2 rounded-lg transition 
                      {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10
                             a1 1 0 001 1h3m10-11l2 2m-2-2v10
                             a1 1 0 01-1 1h-3m-6 0a1 1 0 
                             001-1v-4a1 1 0 011-1h2a1 1 
                             0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <!-- Kelola Data -->
            @php
                $isKelolaDataActive = request()->routeIs('admin.programs.*') ||
                                      request()->routeIs('admin.registrations.verified') ||
                                      request()->routeIs('admin.faq.*');
            @endphp
            <div x-data="{ open: {{ $isKelolaDataActive ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    <span class="flex items-center">
                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 7v10a2 2 0 002 2h14a2 2 
                                  0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 
                                  2 0 00-2 2z"/>
                        </svg>
                        Kelola Data
                    </span>
                    <svg class="h-4 w-4 transform transition-transform duration-200"
                         :class="{ 'rotate-180': open }"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-transition class="pl-10 space-y-1 mt-2">
                    <a href="{{ route('admin.programs.index') }}"
                       class="block px-4 py-2 text-sm rounded-lg transition
                              {{ request()->routeIs('admin.programs.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-700' }}">
                        Kelola Program
                    </a>
    <a href="{{ route('admin.soal.index') }}"
   class="block px-4 py-2 text-sm rounded-lg transition
          {{ request()->routeIs('admin.soal.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-700' }}">
    Kelola Soal
</a>

                    <a href="{{ route('admin.registrations.verified') }}"
                       class="block px-4 py-2 text-sm rounded-lg transition
                              {{ request()->routeIs('admin.registrations.verified') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-700' }}">
                        Kelola Registrasi
                    </a>
                    <a href="{{ route('admin.faq.create') }}"
                       class="block px-4 py-2 text-sm rounded-lg transition
                              {{ request()->routeIs('admin.faq.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-700' }}">
                        Kelola FAQ
                    </a>
                
                </div>
            </div>

            <!-- Verifikasi Registrasi -->
            <a href="{{ route('admin.registrations.verify') }}"
               class="flex items-center px-4 py-2 rounded-lg transition
                      {{ request()->routeIs('admin.registrations.verify') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700 text-gray-300' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0
                             11-18 0 9 9 0 0118 0z"/>
                </svg>
                Verifikasi Registrasi
            </a>
        </nav>

        <!-- Logout -->
        <div class="px-6 py-6 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg transition">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7
                                 m6 4v1a3 3 0 01-3 3H6a3 3 
                                 0 01-3-3V7a3 3 0 013-3h4a3 
                                 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow px-6 py-4 sticky top-0 z-40">
            <h1 class="text-2xl font-semibold text-gray-800">
                @yield('title', 'Dashboard')
            </h1>
        </header>
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 bg-gray-50">
            @yield('content')
        </main>
    </div>

    <!-- Flash Message -->
    @if (session('success'))
        <x-toast type="success" :message="session('success')" />
    @endif
    @if (session('error'))
        <x-toast type="error" :message="session('error')" />
    @endif

</body>
</html>
