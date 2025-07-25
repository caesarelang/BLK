@extends('layouts.app-v2')

@section('content')
    <section class="my-16 max-w-2xl mx-auto px-4" x-data="{ showNotification: {{ session('new_registration') ? 'true' : 'false' }} }">
        <h1 class="text-4xl md:text-5xl font-extrabold text-center mb-12 text-white">Formulir Pendaftaran</h1>

        @if (session('success'))
            <div class="bg-green-500/10 backdrop-blur-xl border-l-4 border-green-500 text-green-100 p-4 mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- New Registration Notification Pop-up -->
        <div x-show="showNotification" @keydown.escape.window="showNotification = false" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4 py-6 z-50" style="display: none;">
            <div class="bg-white/20 backdrop-blur-xl rounded-lg shadow-xl max-w-sm w-full p-6 text-white" @click.away="showNotification = false">
                <h2 class="text-xl font-bold text-blue-400 mb-4">Informasi Pendaftaran</h2>
                <p class="text-gray-100 mb-4">
                    {{ session('new_registration') }}
                </p>
                <div class="flex justify-end">
                    <button @click="showNotification = false" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Oke
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white/10 backdrop-blur-xl p-8 rounded-lg shadow-lg text-white">
            <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label for="nik" class="block text-gray-100 text-sm font-bold mb-2">NIK</label>
                    <input type="text" name="nik" id="nik" value="{{ $nik }}" class="shadow appearance-none border rounded w-full py-2 px-3 bg-white/20 text-white leading-tight focus:outline-none focus:shadow-outline @error('nik') border-red-500 @enderror" required readonly>
                    @error('nik')
                        <p class="text-red-400 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="nama_lengkap" class="block text-gray-100 text-sm font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ $nama_lengkap }}" class="shadow appearance-none border rounded w-full py-2 px-3 bg-white/20 text-white leading-tight focus:outline-none focus:shadow-outline @error('nama_lengkap') border-red-500 @enderror" required readonly>
                    @error('nama_lengkap')
                        <p class="text-red-400 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="id_pelatihan" class="block text-gray-100 text-sm font-bold mb-2">Pilih Kejuruan</label>
                    <select name="id_pelatihan" id="id_pelatihan" class="shadow appearance-none border rounded w-full py-2 px-3 bg-white/20 text-white leading-tight focus:outline-none focus:shadow-outline @error('id_pelatihan') border-red-500 @enderror" required>
                        <option value="">-- Pilih Kejuruan --</option>
                        @foreach ($pelatihans as $pelatihan)
                            <option value="{{ $pelatihan->id_pelatihan }}" {{ old('id_pelatihan') == $pelatihan->id_pelatihan ? 'selected' : '' }} class="bg-gray-800 text-white">
                                {{ $pelatihan->nama_pelatihan }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_pelatihan')
                        <p class="text-red-400 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-gray-100 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="shadow appearance-none border rounded w-full py-2 px-3 bg-white/20 text-white leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-red-400 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="tanggal_lahir" class="block text-gray-100 text-sm font-bold mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="shadow appearance-none border rounded w-full py-2 px-3 bg-white/20 text-white leading-tight focus:outline-none focus:shadow-outline @error('tanggal_lahir') border-red-500 @enderror">
                    @error('tanggal_lahir')
                        <p class="text-red-400 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="url_foto_ijasah" class="block text-gray-100 text-sm font-bold mb-2">Foto Ijazah (Opsional)</label>
                    <input type="file" name="url_foto_ijasah" id="url_foto_ijasah" class="shadow appearance-none border rounded w-full py-2 px-3 bg-white/20 text-white leading-tight focus:outline-none focus:shadow-outline @error('url_foto_ijasah') border-red-500 @enderror">
                    @error('url_foto_ijasah')
                        <p class="text-red-400 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="url_foto_ktp" class="block text-gray-100 text-sm font-bold mb-2">Foto KTP (Opsional)</label>
                    <input type="file" name="url_foto_ktp" id="url_foto_ktp" class="shadow appearance-none border rounded w-full py-2 px-3 bg-white/20 text-white leading-tight focus:outline-none focus:shadow-outline @error('url_foto_ktp') border-red-500 @enderror">
                    @error('url_foto_ktp')
                        <p class="text-red-400 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Daftar
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
