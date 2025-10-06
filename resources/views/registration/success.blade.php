@extends('layouts.app-v2')

@section('content')
<div class="min-h-screen bg-gray-100 py-6">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="mb-6">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Pendaftaran Berhasil!</h1>
            
            <div class="bg-blue-50 rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-blue-800 mb-3">Detail Pendaftaran</h2>
                <div class="space-y-2 text-left">
                    <p><span class="font-medium">Nomor Registrasi:</span> 
                        <span class="text-blue-600 font-mono text-lg">{{ $registrationData['reg_number'] }}</span>
                    </p>
                    <p><span class="font-medium">Nama:</span> {{ $registrationData['full_name'] }}</p>
                    <p><span class="font-medium">Tanggal Daftar:</span> {{ now()->format('d F Y, H:i') }}</p>
                </div>
            </div>
            
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Penting:</strong> Simpan nomor registrasi Anda. 
                            Status pendaftaran akan diproses dalam 1-3 hari kerja.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                    Kembali ke Home
                </a>
                <button onclick="window.print()" 
                        class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg">
                    Print Bukti
                </button>
            </div>
        </div>
    </div>
</div>
@endsection