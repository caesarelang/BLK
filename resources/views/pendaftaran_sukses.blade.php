@extends('layouts.app')

@section('content')
    <section class="my-16 max-w-2xl mx-auto px-4 text-center">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-4xl font-extrabold text-green-600 mb-6">Pendaftaran Berhasil!</h1>
            <p class="text-lg text-gray-700 mb-4">
                Terima kasih telah mendaftar.
            </p>
            <p class="text-gray-600 mb-8">
                Pendaftaran Anda telah kami terima dan akan segera diverifikasi oleh admin kami.
                Mohon tunggu informasi selanjutnya melalui email yang Anda daftarkan.
            </p>
            <a href="{{ route('home') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-transform transform hover:scale-105">
                Kembali ke Beranda
            </a>
        </div>
    </section>
@endsection
