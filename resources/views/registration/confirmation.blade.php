@extends('layouts.app-v2')

@section('content')
<main class="flex-grow">
    <section class="my-12 max-w-2xl mx-auto px-4">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-extrabold text-center mb-2 text-dark">Langkah 4: Konfirmasi Data Anda</h1>
            <p class="text-center text-gray-600 mb-8">Pastikan semua data yang Anda masukkan sudah benar sebelum mengirim.</p>
            
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="space-y-4 text-sm text-dark">
                {{-- Program --}}
                <div class="p-4 bg-gray-50 rounded-md">
                    <h3 class="font-semibold text-lg mb-2">Program Pelatihan</h3>
                    <p><strong>Program:</strong> {{ $program->title ?? 'Tidak Ditemukan' }}</p>
                </div>
                
                {{-- Data Diri --}}
                <div class="p-4 bg-gray-50 rounded-md">
                    <h3 class="font-semibold text-lg mb-2">Data Diri</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                        <p><strong>NIK:</strong> {{ $data['nik'] }}</p>
                        <p><strong>Nama Lengkap:</strong> {{ $data['full_name'] }}</p>
                        <p><strong>Email:</strong> {{ $data['email'] }}</p>
                        <p><strong>No. Telepon:</strong> {{ $data['phone_number'] }}</p>
                        <p><strong>Tanggal Lahir:</strong> {{ \Carbon\Carbon::parse($data['date_of_birth'])->isoFormat('D MMMM Y') }}</p>
                        <p><strong>Pendidikan Terakhir:</strong> {{ $data['last_education'] }}</p>
                        <p class="md:col-span-2"><strong>Alamat:</strong> {{ $data['address'] }}</p>
                    </div>
                </div>

                {{-- Dokumen --}}
                <div class="p-4 bg-gray-50 rounded-md">
                    <h3 class="font-semibold text-lg mb-2">Dokumen Terunggah</h3>
                     <div class="flex items-center gap-4">
                        <a href="{{ $data['ktp_url'] }}" target="_blank" class="text-blue-600 hover:underline">Lihat KTP</a>
                        <a href="{{ $data['pas_foto_url'] }}" target="_blank" class="text-blue-600 hover:underline">Lihat Pas Foto</a>
                        <a href="{{ $data['ijazah_url'] }}" target="_blank" class="text-blue-600 hover:underline">Lihat Ijazah</a>
                    </div>
                </div>
            </div>

            <form action="{{ route('registration.store') }}" method="POST" class="mt-8">
                @csrf
                <div class="flex justify-between items-center">
                    <a href="{{ route('registration.create.step3') }}" class="text-sm text-gray-600 hover:text-dark">&larr; Kembali ke Langkah 3</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-transform transform hover:scale-105">
                        Kirim Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection
