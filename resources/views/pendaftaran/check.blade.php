@extends('layouts.app-v2')

@section('content')
<main class="flex-grow">
    <section class="my-16 max-w-xl mx-auto px-4" x-data="{ showModal: {{ $errors->has('already_registered') ? 'true' : 'false' }} }">
        <h1 class="text-4xl md:text-5xl font-extrabold text-center mb-12 text-white">Cek Pendaftaran</h1>

        <div class="bg-white/10 backdrop-blur-xl p-8 rounded-lg shadow-lg text-white">
            <form action="{{ route('pendaftaran.check') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="nik" class="block text-gray-100 text-sm font-bold mb-2">NIK</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="shadow appearance-none border rounded w-full py-2 px-3 bg-white/20 text-white leading-tight focus:outline-none focus:shadow-outline @error('nik') border-red-500 @enderror" required>
                    @error('nik')
                        <p class="text-red-400 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="nama_lengkap" class="block text-gray-100 text-sm font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" class="shadow appearance-none border rounded w-full py-2 px-3 bg-white/20 text-white leading-tight focus:outline-none focus:shadow-outline @error('nama_lengkap') border-red-500 @enderror" required>
                    @error('nama_lengkap')
                        <p class="text-red-400 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cek Pendaftaran
                    </button>
                </div>
            </form>
        </div>

        <!-- Registration Exists Warning Modal -->
        <div x-show="showModal" @keydown.escape.window="showModal = false" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4 py-6 z-50" style="display: none;">
            <div class="bg-white/20 backdrop-blur-xl rounded-lg shadow-xl max-w-sm w-full p-6 text-white" @click.away="showModal = false">
                <h2 class="text-xl font-bold text-red-400 mb-4">Peringatan!</h2>
                <p class="text-gray-100 mb-4">
                    {{ $errors->first('already_registered') }}
                </p>
                <div class="flex justify-end">
                    <button @click="showModal = false" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
