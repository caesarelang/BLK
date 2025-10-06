@extends('layouts.admin')

@section('content')
    <div class="px-6 py-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Dashboard</h1>
        <p class="text-gray-600 mb-6">Selamat datang di panel admin. Di sini Anda dapat mengelola data aplikasi.</p>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card: FAQ -->
            <div class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-gray-700 mb-3">Manajemen Konten</h2>
                <p class="text-gray-500 mb-4">Kelola FAQ dan konten aplikasi.</p>
                <a href="{{ route('admin.faq.create') }}"
                   class="inline-block text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition">
                    Kelola FAQ
                </a>
            </div>

            <!-- Card: Pengguna -->
            <div class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-gray-700 mb-3">Pengguna</h2>
                <p class="text-gray-500 mb-4">Kelola registrasi dan data pengguna.</p>
                <a href="{{ route('admin.registrations.verified') }}"
                   class="inline-block text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition">
                   Kelola Pengguna
                </a>
            </div>

            <!-- Card: Program -->
            <div class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-gray-700 mb-3">Program Pelatihan</h2>
                <p class="text-gray-500 mb-4">Kelola program dan soal pelatihan.</p>
                <a href="{{ route('admin.programs.index') }}"
                   class="inline-block text-white bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg transition">
                   Kelola Program
                </a>
            </div>

        </div>
    </div>
@endsection
