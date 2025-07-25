<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Upgraded to Alpine.js v3 for better performance and transitions --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('toast', {
                message: '',
                type: 'success',
                show(message, type = 'success') {
                    this.message = message;
                    this.type = type;
                },
                clear() {
                    this.message = '';
                    this.type = 'success';
                }
            })
        });
    </script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-200">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="px-8 py-6">
                <h2 class="text-2xl font-semibold">Admin Panel</h2>
            </div>
            <nav class="flex-1 px-4 py-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded">
                    <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                
                <div x-data="{ open: false }" class="mt-2">
                    <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded">
                        <span class="flex items-center">
                            <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                            Kelola Data
                        </span>
                        <svg class="h-5 w-5 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open" class="pl-8 py-2">
                        <a href="{{ route('admin.pelatihan.index') }}" class="block px-4 py-2 text-sm text-gray-100 hover:bg-gray-700 rounded">Kelola Pelatihan</a>
                        <a href="{{ route('admin.data.peserta') }}" class="block px-4 py-2 text-sm text-gray-100 hover:bg-gray-700 rounded">Kelola Peserta</a>
                    </div>
                </div>

                <a href="{{ route('admin.verifikasi.peserta') }}" class="flex items-center px-4 py-2 mt-2 text-gray-100 hover:bg-gray-700 rounded">
                    <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Verifikasi Peserta
                </a>
            </nav>
            <div class="px-8 py-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2 text-gray-100 bg-red-600 hover:bg-red-700 rounded">
                        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 p-6">
                @yield('content')
            </main>
        </div>
    </div>
    @include('components.toast')
</body>
</html>
