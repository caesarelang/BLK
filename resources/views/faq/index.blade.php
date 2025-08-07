{{-- Menggunakan layout utama --}}
@extends('layouts.app-v2') 

{{-- Mendefinisikan judul halaman --}}
@section('title', 'Pertanyaan Umum (FAQ)')

@section('content')
<div class="py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Judul Halaman --}}
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-dark tracking-tight">
                Pertanyaan Umum (FAQ)
            </h1>
            <p class="mt-3 text-lg text-gray-600 max-w-2xl mx-auto">
                Temukan jawaban atas pertanyaan yang sering diajukan.
            </p>
        </div>

        {{-- Kontainer untuk daftar FAQ --}}
        <div class="max-w-4xl mx-auto">
            <div class="space-y-8">

                {{-- Looping melalui setiap FAQ --}}
                @forelse ($faqs as $faq)
                    <article class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                        <div class="p-6 md:p-8">
                            <header class="mb-4">
                                {{-- Pertanyaan FAQ --}}
                                <h2 class="text-2xl font-bold text-dark">
                                    {{ $faq->question }}
                                </h2>
                                {{-- Tanggal Publikasi (jika relevan, atau hapus jika tidak) --}}
                                <p class="text-sm text-gray-500 mt-2">
                                    Dipublikasikan pada: @if ($faq->created_at)
                                        {{ $faq->created_at->translatedFormat('l, d F Y') }}
                                    @else
                                        Tanggal tidak tersedia
                                    @endif
                                </p>
                            </header>
                            
                            {{-- Jawaban FAQ --}}
                            <div class="prose prose-blue max-w-none text-gray-700">
                                {!! nl2br(e($faq->answer)) !!}
                            </div>
                        </div>
                    </article>
                @empty
                    {{-- Pesan jika tidak ada FAQ --}}
                    <div class="text-center bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-6 rounded-md shadow-md">
                        <p class="font-bold text-xl">Belum Ada Pertanyaan Umum</p>
                        <p class="mt-2">Saat ini belum ada pertanyaan umum yang dipublikasikan. Silakan periksa kembali nanti.</p>
                    </div>
                @endforelse
                
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
{{-- Menambahkan sedikit CSS kustom jika diperlukan --}}
<style>
    .prose-blue a {
        color: #2563eb;
    }
    .prose-blue a:hover {
        color: #1d4ed8;
    }
</style>
@endpush
</body>
</html>