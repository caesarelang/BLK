@extends('layouts.app-v2')

@section('content')
<main class="flex-grow">
    <section class="my-12 max-w-2xl mx-auto px-4">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-extrabold text-center mb-2 text-dark">Langkah 3: Unggah Dokumen</h1>
            <p class="text-center text-gray-600 mb-8">Unggah file KTP, Pas Foto, dan Ijazah terakhir Anda.</p>

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('registration.store.step3') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="ktp_file" class="block text-dark text-sm font-bold mb-2">Upload Foto KTP</label>
                    <input type="file" name="ktp_file" id="ktp_file"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('ktp_file') border-red-500 @enderror" required>
                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, JPEG. Maks 2MB.</p>
                    @error('ktp_file')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label for="pas_foto_file" class="block text-dark text-sm font-bold mb-2">Upload Pas Foto (3x4)</label>
                    <input type="file" name="pas_foto_file" id="pas_foto_file"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('pas_foto_file') border-red-500 @enderror" required>
                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, JPEG. Latar belakang merah/biru.</p>
                    @error('pas_foto_file')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="ijazah_file" class="block text-dark text-sm font-bold mb-2">Upload Ijazah Terakhir</label>
                    <input type="file" name="ijazah_file" id="ijazah_file"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('ijazah_file') border-red-500 @enderror" required>
                     <p class="mt-1 text-xs text-gray-500">PNG, JPG, JPEG. Maks 2MB.</p>
                    @error('ijazah_file')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-between pt-4">
                    <a href="{{ route('registration.create.step2') }}" class="text-sm text-gray-600 hover:text-dark">&larr; Kembali</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-transform transform hover:scale-105">
                        Lanjutkan ke Konfirmasi &rarr;
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection
