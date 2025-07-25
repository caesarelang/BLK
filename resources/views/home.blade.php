@extends('layouts.app-v2')

@section('content')
    <!-- Hero Section -->
    <section class="relative w-full h-[500px] md:h-[600px] overflow-hidden">
        {{-- Image slider as background --}}
        <div x-data="{
            images: [
                '{{ asset('images/barista.jpg') }}',
                '{{ asset('images/design.jpg') }}',
                '{{ asset('images/taylor.jpg') }}'
            ],
            currentIndex: 0,
            nextImage() {
                this.currentIndex = (this.currentIndex + 1) % this.images.length;
            },
            prevImage() {
                this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
            },
            init() {
                // Auto-slide every 5 seconds
                setInterval(() => {
                    this.nextImage();
                }, 5000);
            }
        }" class="absolute inset-0 w-full h-full">
            <template x-for="(image, index) in images" :key="index">
                <img 
                    x-show="currentIndex === index" 
                    :src="image" 
                    :alt="'Gambar Pelatihan ' + (index + 1)" 
                    class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out"
                    x-transition:enter="opacity-0"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="opacity-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                >
            </template>
            {{-- Overlay for text readability --}}
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>

            <!-- Navigation Arrows -->
            <button @click="prevImage()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full focus:outline-none hover:bg-opacity-75 transition-colors z-20">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button @click="nextImage()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full focus:outline-none hover:bg-opacity-75 transition-colors z-20">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>

        {{-- Text Content positioned over the image --}}
        <div class="relative z-10 h-full flex items-center justify-start">
            <div class="max-w-4xl mx-auto px-4 w-full">
                <div class="text-white text-left max-w-xl">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-2 leading-tight">
                              Balai Latihan Kerja
                    </h1>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-100">Disnakertrans Kabupaten Kediri</h3>
                    
                    <p class="text-lg md:text-xl mb-8 text-gray-100">
                        Bergabunglah dengan ribuan profesional yang telah meningkatkan karir mereka melalui pelatihan intensif dan terfokus dari instruktur ahli di bidangnya.
                    </p>
                    <a href="{{ route('kejuruan') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-xl transition-transform transform hover:scale-105 text-lg">
                        Lihat Semua Kejuruan
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="my-20">
        <h2 class="text-3xl font-bold text-center mb-12 text-white">Mengapa Memilih Balai Latihan Kerja?</h2>
        <div class="max-w-4xl mx-auto bg-white/10 backdrop-blur-xl p-8 rounded-lg shadow-lg px-4 text-white">
            <div class="flex flex-col md:flex-row justify-between space-y-8 md:space-y-0 md:space-x-8">
                <!-- Benefit 1 -->
                <div class="text-center md:text-left">
                    <div class="text-4xl text-blue-400 mb-4 mx-auto md:mx-0">🏆</div>
                    <h3 class="text-xl font-bold mb-2">Kurikulum Standar Industri</h3>
                    <p class="text-gray-100">Materi yang kami ajarkan disusun bersama para ahli untuk memastikan relevansi dengan kebutuhan dunia kerja saat ini.</p>
                </div>
                <!-- Benefit 2 -->
                <div class="text-center md:text-left">
                    <div class="text-4xl text-blue-400 mb-4 mx-auto md:mx-0">👨‍🏫</div>
                    <h3 class="text-xl font-bold mb-2">Instruktur Berpengalaman</h3>
                    <p class="text-gray-100">Belajar langsung dari praktisi profesional yang telah bertahun-tahun berkarir di bidangnya masing-masing.</p>
                </div>
                <!-- Benefit 3 -->
                <div class="text-center md:text-left">
                    <div class="text-4xl text-blue-400 mb-4 mx-auto md:mx-0">📄</div>
                    <h3 class="text-xl font-bold mb-2">Sertifikat Resmi</h3>
                    <p class="text-gray-100">Dapatkan sertifikat kompetensi yang diakui untuk meningkatkan nilai jual Anda di mata perusahaan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="my-20 max-w-4xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-white">Frequently Asked Questions (FAQ)</h2>
        <div class="space-y-4">
            <!-- FAQ 1 -->
            <div x-data="{ open: false }" class="bg-white/10 backdrop-blur-xl rounded-lg shadow-sm text-white">
                <button @click="open = !open" class="w-full flex justify-between items-center text-left p-5">
                    <h3 class="font-semibold text-lg">Apakah pelatihan ini cocok untuk pemula?</h3>
                    <svg class="w-6 h-6 transition-transform duration-300" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-transition class="px-5 pb-5 text-gray-100">
                    <p>Tentu saja! Kami memiliki berbagai pilihan kejuruan yang dirancang khusus untuk pemula tanpa latar belakang IT sama sekali. Materi akan diajarkan dari dasar.</p>
                </div>
            </div>
            <!-- FAQ 2 -->
            <div x-data="{ open: false }" class="bg-white/10 backdrop-blur-xl rounded-lg shadow-sm text-white">
                <button @click="open = !open" class="w-full flex justify-between items-center text-left p-5">
                    <h3 class="font-semibold text-lg">Bagaimana cara mendaftarnya?</h3>
                    <svg class="w-6 h-6 transition-transform duration-300" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-transition class="px-5 pb-5 text-gray-100">
                    <p>Anda bisa mengklik tombol "Daftar" di pojok kanan atas, kemudian pilih kejuruan yang diminati, dan isi formulir pendaftaran yang tersedia.</p>
                </div>
            </div>
            <!-- FAQ 3 -->
            <div x-data="{ open: false }" class="bg-white/10 backdrop-blur-xl rounded-lg shadow-sm text-white">
                <button @click="open = !open" class="w-full flex justify-between items-center text-left p-5">
                    <h3 class="font-semibold text-lg">Apakah ada jaminan kerja setelah lulus?</h3>
                    <svg class="w-6 h-6 transition-transform duration-300" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-transition class="px-5 pb-5 text-gray-100">
                    <p>Kami tidak memberikan jaminan kerja, namun kami memiliki program penyaluran kerja dan career coaching yang akan membantu Anda mempersiapkan diri untuk memasuki dunia kerja, mulai dari pembuatan CV hingga persiapan interview.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
