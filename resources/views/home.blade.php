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

    <!-- Card Benefit Section -->
    <section id="benefits" class="w-full py-12 md:py-24 bg-background">
        {{-- Menyesuaikan kontainer agar konsisten --}}
        <div class="max-w-4xl mx-auto px-4 md:px-6">
            <div class="flex flex-col items-center space-y-4 text-center mb-12">
                <h2 class="text-3xl font-bold tracking-tighter sm:text-5xl text-dark">Mengapa Memilih Kami?</h2>
                <p class="max-w-3xl text-gray-600 md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                    Kami menyediakan lingkungan belajar terbaik untuk kesuksesan karir Anda.
                </p>
            </div>
            {{-- Menghapus max-w-5xl dari grid agar mengikuti kontainer induk --}}
            <div class="mx-auto grid items-stretch gap-8 sm:grid-cols-2 md:grid-cols-3">
                <div class="text-center flex flex-col transition-all duration-300 hover:shadow-lg hover:-translate-y-2 rounded-lg bg-white p-6">
                    <div class="flex justify-center mb-4"><img src="https://img.icons8.com/3d-fluency/94/certificate.png" alt="Instruktur Bersertifikat" width="94" height="94" /></div>
                    <h3 class="text-xl font-bold text-dark">Instruktur Bersertifikat</h3>
                    <div class="flex-grow pt-4">
                        <p class="text-gray-600">Belajar dari para ahli industri yang memiliki sertifikasi dan pengalaman terbukti.</p>
                    </div>
                </div>
                <div class="text-center flex flex-col transition-all duration-300 hover:shadow-lg hover:-translate-y-2 rounded-lg bg-white p-6">
                    <div class="flex justify-center mb-4"><img src="https://img.icons8.com/3d-fluency/94/books.png" alt="Kurikulum Relevan" width="94" height="94" /></div>
                    <h3 class="text-xl font-bold text-dark">Kurikulum Relevan</h3>
                    <div class="flex-grow pt-4">
                        <p class="text-gray-600">Materi pelatihan disusun sesuai dengan kebutuhan industri kerja saat ini.</p>
                    </div>
                </div>
                <div class="text-center flex flex-col transition-all duration-300 hover:shadow-lg hover:-translate-y-2 rounded-lg bg-white p-6">
                    <div class="flex justify-center mb-4"><img src="https://img.icons8.com/3d-fluency/94/handshake.png" alt="Bantuan Penempatan Kerja" width="94" height="94" /></div>
                    <h3 class="text-xl font-bold text-dark">Bantuan Penempatan Kerja</h3>
                    <div class="flex-grow pt-4">
                        <p class="text-gray-600">Kami membantu menyalurkan lulusan terbaik ke perusahaan-perusahaan mitra kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="my-20 max-w-4xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-dark">Frequently Asked Questions (FAQ)</h2>
        <div class="space-y-4">
            @forelse ($faqs as $faq)
                <div x-data="{ open: false }" class="bg-white rounded-lg shadow-sm text-dark">
                    <button @click="open = !open" class="w-full flex justify-between items-center text-left p-5">
                        <h3 class="font-semibold text-lg">{{ $faq->question }}</h3>
                        <svg class="w-6 h-6 transition-transform duration-300" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="px-5 pb-5 text-gray-600">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
            @empty
                <div class="text-center bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-6 rounded-md shadow-md">
                    <p class="font-bold text-xl">Belum Ada Pertanyaan Umum</p>
                    <p class="mt-2">Saat ini belum ada pertanyaan umum yang tersedia. Silakan periksa kembali nanti.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
