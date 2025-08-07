@extends('layouts.app-v2')

@section('content')
    <section class="my-16 max-w-2xl mx-auto px-4" x-data="{ showNotification: {{ session('new_registration') ? 'true' : 'false' }} }">
        <h1 class="text-4xl md:text-5xl font-extrabold text-center mb-12 text-dark">Formulir Pendaftaran</h1>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">Terjadi kesalahan:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <!-- New Registration Notification Pop-up -->
        <div x-show="showNotification" @keydown.escape.window="showNotification = false" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center px-4 py-6 z-50" style="display: none;">
            <div class="bg-white rounded-lg shadow-xl max-w-sm w-full p-6" @click.away="showNotification = false">
                <h2 class="text-xl font-bold text-blue-600 mb-4">Informasi Pendaftaran</h2>
                <p class="text-gray-700 mb-4">
                    {{ session('new_registration') }}
                </p>
                <div class="flex justify-end">
                    <button @click="showNotification = false" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Oke
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-lg">
            <form action="{{ route('registration.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="nik" class="block text-dark text-sm font-bold mb-2">NIK</label>
                    <input type="text" name="nik" id="nik" value="{{ $nik }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-dark leading-tight focus:outline-none focus:shadow-outline bg-gray-100 @error('nik') border-red-500 @enderror" required readonly>
                    @error('nik')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="full_name" class="block text-dark text-sm font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="full_name" id="full_name" value="{{ $full_name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-dark leading-tight focus:outline-none focus:shadow-outline bg-gray-100 @error('full_name') border-red-500 @enderror" required readonly>
                    @error('full_name')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="program_id" class="block text-dark text-sm font-bold mb-2">Pilih Program</label>
                    <select name="program_id" id="program_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-dark leading-tight focus:outline-none focus:shadow-outline @error('program_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Program --</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->program_id }}" {{ old('program_id') == $program->program_id ? 'selected' : '' }}>
                                {{ $program->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('program_id')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-dark text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-dark leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="date_of_birth" class="block text-dark text-sm font-bold mb-2">Tanggal Lahir</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-dark leading-tight focus:outline-none focus:shadow-outline @error('date_of_birth') border-red-500 @enderror">
                    @error('date_of_birth')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Alamat:</label>
                    <textarea name="address" id="address" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">Nomor Telepon:</label>
                    <input type="text" name="phone_number" id="phone_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone_number') border-red-500 @enderror" value="{{ old('phone_number') }}">
                    @error('phone_number')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="last_education" class="block text-gray-700 text-sm font-bold mb-2">Pendidikan Terakhir:</label>
                    <input type="text" name="last_education" id="last_education" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('last_education') border-red-500 @enderror" value="{{ old('last_education') }}">
                    @error('last_education')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
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
