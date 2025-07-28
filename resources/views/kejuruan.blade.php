@extends('layouts.app-v2')

@section('content')
    <section class="my-16 max-w-4xl mx-auto px-4" x-data="{ openModal: {} }">
        <h1 class="text-4xl md:text-5xl font-extrabold text-center mb-12 text-dark">Pilihan Kejuruan</h1>

        @if($pelatihans->isEmpty())
            <p class="text-center text-gray-600 text-lg">Belum ada pelatihan yang tersedia saat ini. Silakan cek kembali nanti!</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($pelatihans as $pelatihan)
                    {{-- Card container with flex column layout to align items vertically --}}
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col text-dark">
                        <img src="{{ $pelatihan->url_foto_pelatihan ?: 'https://via.placeholder.com/400x250?text=Gambar+Pelatihan' }}" alt="{{ $pelatihan->nama_pelatihan }}" class="w-full h-48 object-cover">
                        
                        {{-- Content area that grows to fill available vertical space --}}
                        <div class="p-6 flex flex-col flex-grow">
                            {{-- This div contains the main content (title, details) --}}
                            <div>
                                <h3 class="font-bold text-xl mb-2 min-h-[56px]"> {{-- Added min-height for title consistency (2 lines) --}}
                                    <button @click="openModal['{{ $pelatihan->id_pelatihan }}'] = true" class="text-blue-600 hover:text-blue-700 focus:outline-none text-left">
                                        {{ $pelatihan->nama_pelatihan }}
                                    </button>
                                </h3>
                                <div class="text-sm text-gray-600 mb-2 space-y-1">
                                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($pelatihan->tanggal_berakhir)->translatedFormat('d M Y') }}</p>
                                    <p><strong>Lokasi:</strong> {{ $pelatihan->lokasi ?: 'Online' }}</p>
                                    <p><strong>Kuota:</strong> {{ $pelatihan->kuota ?: 'Tidak Terbatas' }}</p>
                                </div>
                            </div>

                            {{-- Button container, pushed to the bottom by mt-auto --}}
                            <div class="mt-auto pt-4"> 
                                <a href="{{ route('pendaftaran.checkForm') }}" class="w-full inline-block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition-transform transform hover:scale-105">
                                    Daftar Sekarang
                                a>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div x-show="openModal['{{ $pelatihan->id_pelatihan }}']" @keydown.escape.window="openModal['{{ $pelatihan->id_pelatihan }}'] = false" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4 py-6 z-50" style="display: none;">
                        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full overflow-hidden text-dark" @click.away="openModal['{{ $pelatihan->id_pelatihan }}'] = false">
                            <img src="{{ $pelatihan->url_foto_pelatihan ?: 'https://via.placeholder.com/400x250?text=Gambar+Pelatihan' }}" alt="{{ $pelatihan->nama_pelatihan }}" class="w-full h-56 object-cover">
                            <div class="p-6">
                                <h2 class="text-2xl font-bold mb-2">{{ $pelatihan->nama_pelatihan }}</h2>
                                <div class="text-sm text-gray-600 mb-4 space-y-1">
                                    <p><strong>Deskripsi:</strong></p>
                                    <p class="text-gray-700 whitespace-pre-wrap text-base">{{ $pelatihan->deskripsi }}</p>
                                </div>
                                <div class="mt-6 flex justify-end">
                                    <button @click="openModal['{{ $pelatihan->id_pelatihan }}'] = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection
