{{-- File: resources/views/admin/peserta/verified.blade.php --}}
@extends('layouts.admin')

@section('content')
<div x-data="{ showImageModal: false, imageUrl: '' }">
    <h1 class="text-3xl font-bold mb-6">Kelola Registrasi Terverifikasi</h1>

    @if($registrations->isEmpty())
        <div class="bg-white p-8 rounded-lg shadow-md text-center">
            <p class="text-gray-500 text-lg">Tidak ada registrasi yang terverifikasi saat ini.</p>
        </div>
    @else
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Peserta</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Program Pelatihan</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIK</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status Registrasi</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nomor Registrasi</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $registration)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $registration->participant->full_name ?? 'N/A' }}</p>
                                <p class="text-gray-600 whitespace-no-wrap">{{ $registration->participant->email ?? 'N/A' }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $registration->program->title ?? 'N/A' }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $registration->participant->nik ?? 'N/A' }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                @php
                                    $statusConfig = [
                                        'diterima' => ['text' => 'text-blue-900', 'bg' => 'bg-blue-200', 'label' => 'Diterima'],
                                        'ditolak' => ['text' => 'text-red-900', 'bg' => 'bg-red-200', 'label' => 'Ditolak'],
                                        'disetujui' => ['text' => 'text-green-900', 'bg' => 'bg-green-200', 'label' => 'Disetujui'],
                                        'gagal' => ['text' => 'text-yellow-900', 'bg' => 'bg-yellow-200', 'label' => 'Gagal'],
                                    ];
                                    $currentStatus = strtolower($registration->status);
                                    $config = $statusConfig[$currentStatus] ?? ['text' => 'text-gray-900', 'bg' => 'bg-gray-200', 'label' => $registration->status];
                                @endphp
                                
                                <span class="relative inline-block px-3 py-1 font-medium leading-tight text-sm {{ $config['text'] }}">
                                    <span aria-hidden="true" class="absolute inset-0 {{ $config['bg'] }} opacity-50 rounded-full"></span>
                                    <span class="relative">{{ $config['label'] }}</span>
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $registration->registration_number }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                @if(strtolower($registration->status) === 'gagal')
                                    <form action="{{ route('admin.registrations.retake-exam', $registration) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs transition duration-300 ease-in-out transform hover:scale-105"
                                                onclick="return confirm('Apakah Anda yakin ingin memberikan kesempatan ujian ulang untuk {{ $registration->participant->full_name }}?')">
                                            <i class="fas fa-redo mr-1"></i>
                                            Ujian Ulang
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs italic">Tidak ada aksi tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination jika diperlukan -->
        @if(method_exists($registrations, 'links'))
            <div class="mt-6">
                {{ $registrations->links() }}
            </div>
        @endif
    @endif
</div>

<!-- Toast Notification -->
@if(session('success'))
    <div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-300">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }
        }, 3000);
    </script>
@endif

@if(session('error'))
    <div id="toast-error" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-300">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast-error');
            if (toast) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }
        }, 3000);
    </script>
@endif

<style>
.table-responsive {
    overflow-x: auto;
}

@media (max-width: 768px) {
    table {
        font-size: 0.875rem;
    }
    
    .px-5 {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
}
</style>
@endsection