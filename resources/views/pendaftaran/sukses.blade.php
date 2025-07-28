@extends('layouts.app-v2')

@section('content')
    <section class="my-16 max-w-2xl mx-auto px-4">
        <div class="bg-white p-8 rounded-lg shadow-lg text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-green-600 mb-4">Pendaftaran Berhasil!</h1>
            <p class="text-gray-700 text-lg mb-8">
                Terima kasih telah mendaftar. Kami akan segera memverifikasi data Anda.
            </p>
            <a href="/" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition-transform transform hover:scale-105">
                Kembali ke Halaman Utama
            </a>
        </div>
    </section>
@endsection
