@extends('layouts.app-v2')

@section('title', 'Status Registrasi')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white text-center py-4">
            <h2 class="text-xl font-bold">Status Registrasi</h2>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-6">
            <div class="text-center">
                <p class="text-gray-700 text-sm">Nomor Registrasi</p>
                <p class="text-lg font-bold text-blue-600">{{ $registration->registration_number }}</p>
            </div>

            <div class="border-t pt-4">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                        <dd class="mt-1 text-gray-900">{{ $registration->participant->full_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Program</dt>
                        <dd class="mt-1 text-gray-900">{{ $registration->program->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Registrasi</dt>
                        <dd class="mt-1 text-gray-900">
                            {{ \Carbon\Carbon::parse($registration->registration_date)->format('d M Y') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            @php
                                $statusColor = match($registration->status) {
                                    'menunggu' => 'bg-yellow-100 text-yellow-800',
                                    'diterima' => 'bg-green-100 text-green-800',
                                    'ditolak' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="px-3 py-1 inline-flex text-sm font-medium rounded-full {{ $statusColor }}">
                                {{ ucfirst($registration->status) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Jika status diterima -->
            @if($registration->status === 'disetujui')
                <div class="pt-6 text-center">
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center px-5 py-3 bg-green-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-green-700 transition">
                        <i class="bi bi-box-arrow-in-right mr-2"></i> Login
                    </a>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 text-center py-4">
            <a href="{{ route('registration.check') }}" 
               class="text-blue-600 hover:text-blue-800 font-medium">
                ← Kembali ke Halaman Cek Status
            </a>
        </div>
    </div>
</div>
@endsection
