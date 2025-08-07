@extends('layouts.app-v2')

@section('content')
<main class="flex-grow">
    <section class="my-16 text-center">
        <div class="container mx-auto py-12 text-center">
            <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg border-t-4 border-green-500">
                <svg class="h-16 w-16 text-green-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h1 class="mt-4 text-3xl font-extrabold text-dark">Pendaftaran Berhasil!</h1>
                <p class="mt-4 text-gray-600">
                    Terima kasih, <strong>{{ $data['full_name'] }}</strong>. Pendaftaran Anda telah kami terima. 
                    Silakan simpan nomor registrasi di bawah ini untuk melakukan pengecekan status kelulusan Anda di kemudian hari.
                </p>
                <div class="mt-6 bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Nomor Registrasi Anda</p>
                    <p class="text-2xl font-bold tracking-widest text-dark">{{ $data['reg_number'] }}</p>
                </div>
                <div class="mt-8">
                    <a href="{{ route('home') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition-transform transform hover:scale-105">
                        Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
