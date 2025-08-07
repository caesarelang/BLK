@extends('layouts.app-v2')

@section('content')
<main class="flex-grow">
    <section class="my-12 max-w-2xl mx-auto px-4">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-extrabold text-center mb-2 text-dark">Langkah 1: Data Diri</h1>
            <p class="text-center text-gray-600 mb-8">Masukkan data diri Anda sesuai dengan KTP.</p>
            
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('registration.store.step1') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="nik" class="block text-dark text-sm font-bold mb-2">NIK</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik', $data['nik'] ?? '') }}"
                           class="shadow appearance-none border rounded w-full py-3 px-4 text-dark leading-tight focus:outline-none focus:shadow-outline @error('nik') border-red-500 @enderror"
                           placeholder="16 digit NIK Anda" required>
                    @error('nik')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="full_name" class="block text-dark text-sm font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $data['full_name'] ?? '') }}"
                           class="shadow appearance-none border rounded w-full py-3 px-4 text-dark leading-tight focus:outline-none focus:shadow-outline @error('full_name') border-red-500 @enderror"
                           placeholder="Sesuai KTP" required>
                    @error('full_name')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="email" class="block text-dark text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $data['email'] ?? '') }}"
                           class="shadow appearance-none border rounded w-full py-3 px-4 text-dark leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                           placeholder="email@anda.com" required>
                    @error('email')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="phone_number" class="block text-dark text-sm font-bold mb-2">Nomor Telepon/WA</label>
                    <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number', $data['phone_number'] ?? '') }}"
                           class="shadow appearance-none border rounded w-full py-3 px-4 text-dark leading-tight focus:outline-none focus:shadow-outline @error('phone_number') border-red-500 @enderror"
                           placeholder="08xxxxxxxxxx" required>
                    @error('phone_number')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-end pt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-transform transform hover:scale-105">
                        Lanjutkan &rarr;
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection
