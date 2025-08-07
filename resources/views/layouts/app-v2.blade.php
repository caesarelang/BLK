<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pusat Pelatihan</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,900&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .text-dark {
            color: #171717;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    // Clear input fields after form submission
                    form.querySelectorAll('input, textarea, select').forEach(input => {
                        if (input.type === 'text' || input.type === 'email' || input.type === 'date' || input.tagName === 'TEXTAREA') {
                            input.value = '';
                        } else if (input.tagName === 'SELECT') {
                            input.selectedIndex = 0; // Reset to the first option
                        } else if (input.type === 'checkbox' || input.type === 'radio') {
                            input.checked = false;
                        }
                    });
                });
            });
        });
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 text-dark flex flex-col min-h-screen">
    <!-- Navbar -->
    <header class="bg-gray-100 sticky top-0 z-50">
        <div x-data="{ open: false }" class="relative max-w-4xl mx-auto px-4">
            <div class="flex justify-between items-center py-6">
                <!-- Left Section: Logo & Nav Links -->
                <div class="flex items-center space-x-8">
                    <div>
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">Balai Latihan Kerja</a>
                        <p class="text-sm text-gray-500">Kabupaten Kediri</p>
                    </div>
                    <nav class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('home') }}" class="text-dark hover:text-blue-600 font-medium {{ request()->routeIs('home') ? 'underline font-bold' : '' }}">Home</a>
                        <a href="{{ route('kejuruan') }}" class="text-dark hover:text-blue-600 font-medium {{ request()->routeIs('kejuruan') ? 'underline font-bold' : '' }}">Kejuruan</a>
                        <a href="{{ route('faq.index') }}" class="text-dark hover:text-blue-600 font-medium {{ request()->routeIs('faq.index') ? 'underline font-bold' : '' }}">FAQ</a>
                    </nav>
                </div>

                <!-- Right Section: Desktop Register Button -->
                <div class="hidden md:flex items-center">
                    <a href="{{ route('registration.create.step1') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-transform transform hover:scale-105">
                        Daftar
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button @click="open = !open" class="text-dark focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!open" d="M4 6h16M4 12h16m-7 6h7"></path>
                            <path x-show="open" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" @click.away="open = false" class="md:hidden pb-4">
                <nav class="flex flex-col space-y-3">
                    <a href="{{ route('home') }}" class="text-dark hover:text-blue-600 font-medium">Home</a>
                    <a href="{{ route('kejuruan') }}" class="text-dark hover:text-blue-600 font-medium">Kejuruan</a>
                    <a href="{{ route('faq.index') }}" class="text-dark hover:text-blue-600 font-medium">FAQ</a>
                </nav>
                <hr class="my-4 border-gray-300">
                <a href="{{ route('registration.create.step1') }}" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition-transform transform hover:scale-105">
                    Daftar
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 text-dark mt-16 pt-12 pb-8">
        <div class="max-w-4xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About Section -->
                <div>
                    <h3 class="text-lg font-semibold text-dark">Balai Latihan Kerja</h3>
                    <p class="mt-2 text-sm text-gray-600">Menyediakan pelatihan berkualitas untuk meningkatkan kompetensi dan daya saing tenaga kerja di era digital.</p>
                </div>
                
                <!-- Contact & Social Media Section -->
                <div>
                    <div>
                        <h3 class="text-lg font-semibold text-dark">Alamat Kami</h3>
                        <address class="mt-2 text-sm not-italic text-gray-600">
                        Jl. PLK No.9, Mulyosari, Bogokidul,<br>
                        Kec. Plemahan, Kabupaten Kediri,<br>
                        Jawa Timur 64155<br>
                            <a href="tel:021-123-4567" class="hover:text-blue-600">Telp: (021) 123-4567</a><br>
                            <a href="mailto:info@blk.go.id" class="hover:text-blue-600">Email: info@blk.go.id</a>
                        </address>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-dark">Media Sosial</h3>
                        <div class="flex space-x-4 mt-2">
                            <a href="#" class="text-gray-500 hover:text-blue-600">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-blue-600">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.013-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.74.055-3.75a4.2 4.2 0 00-.52-2.132 3.402 3.402 0 00-1.24-1.054 3.402 3.402 0 00-2.132-.52c-1.01-.044-1.35-.055-3.75-.055s-2.74.011-3.75.055zm.306 4.695a3.576 3.576 0 106.848 1.485 3.576 3.576 0 00-6.848-1.485zM12 15a3 3 0 110-6 3 3 0 010 6z" clip-rule="evenodd" /></svg>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-blue-600">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Google Maps Embed Section -->
                <div>
                    <h3 class="text-lg font-semibold text-dark mb-4">Lokasi Kami</h3>
                    <div class="w-full h-64 rounded-lg overflow-hidden shadow-md">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.7043543007726!2d112.12576887500425!3d-7.714837692303025!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e785b45790368dd%3A0xe27bb5bf5e62344c!2sBalai%20Latihan%20Kerja!5e0!3m2!1sid!2sid!4v1753166396347!5m2!1sid!2sid" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

            <div class="mt-12 border-t border-gray-200 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} Balai Latihan Kerja. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>