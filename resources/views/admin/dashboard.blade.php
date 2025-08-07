@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>
    <p class="text-gray-700">Selamat datang di panel admin. Di sini Anda dapat mengelola data aplikasi.</p>

    <div class="mt-8">
        <h2 class="text-2xl font-semibold mb-4">Manajemen Konten</h2>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.faq.index') }}" class="text-blue-600 hover:underline">Kelola FAQ</a>
            </li>
        </ul>
    </div>
@endsection
