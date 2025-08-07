@extends('layouts.app-v2')

@section('content')
    <section class="my-16 max-w-4xl mx-auto px-4" x-data="{ openModal: {} }">
        <h1 class="text-4xl md:text-5xl font-extrabold text-center mb-12 text-dark">Pilihan Kejuruan</h1>

        @if($programs->isEmpty())
            <p class="text-center text-gray-600 text-lg">Belum ada program yang tersedia saat ini. Silakan cek kembali nanti!</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($programs as $program)
                    {{-- Card container with flex column layout to align items vertically --}}
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col text-dark">
                        <img src="{{ $program->image_url ?: 'https://via.placeholder.com/400x250?text=Gambar+Program' }}" alt="{{ $program->title }}" class="w-full h-48 object-cover">
                        
                        {{-- Content area that grows to fill available vertical space --}}
                        <div class="p-6 flex flex-col flex-grow">
                            {{-- This div contains the main content (title, details) --}}
                            <div>
                                <h3 class="font-bold text-xl mb-2 min-h-[56px]"> {{-- Added min-height for title consistency (2 lines) --}}
                                    <button @click="openModal['{{ $program->program_id }}'] = true" class="text-blue-600 hover:text-blue-700 focus:outline-none text-left">
                                        {{ $program->title }}
                                    </button>
                                </h3>
                                <div class="text-sm text-gray-600 mb-2 space-y-1">
                                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($program->start_date)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($program->end_date)->translatedFormat('d M Y') }}</p>
                                    {{-- Removed Lokasi and Kuota as they are not in the new schema --}}
                                </div>
                            </div>

                            {{-- Button container, pushed to the bottom by mt-auto --}}
                            <div class="mt-auto pt-4"> 
                                <a href="{{ route('registration.create.step1') }}" class="w-full inline-block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition-transform transform hover:scale-105">
                                    Daftar Sekarang
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div x-show="openModal['{{ $program->program_id }}']" @keydown.escape.window="openModal['{{ $program->program_id }}'] = false" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4 py-6 z-50" style="display: none;">
                        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full overflow-hidden text-dark" @click.away="openModal['{{ $program->program_id }}'] = false">
                            <img src="{{ $program->image_url ?: 'https://via.placeholder.com/400x250?text=Gambar+Program' }}" alt="{{ $program->title }}" class="w-full h-56 object-cover">
                            <div class="p-6">
                                <h2 class="text-2xl font-bold mb-2">{{ $program->title }}</h2>
                                <div class="text-sm text-gray-600 mb-4 space-y-1">
                                    <p><strong>Deskripsi:</strong></p>
                                    <p class="text-gray-700 whitespace-pre-wrap text-base">{{ $program->description }}</p>
                                    <p><strong>Persyaratan:</strong></p>
                                    <p class="text-gray-700 whitespace-pre-wrap text-base">{{ $program->requirements }}</p>
                                </div>
                                <div class="mt-6 flex justify-end">
                                    <button @click="openModal['{{ $program->program_id }}'] = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
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
