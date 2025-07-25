@extends('layouts.admin')

@section('content')
<div x-data="{ showImageModal: false, imageUrl: '' }">
    <h1 class="text-3xl font-bold mb-6">Kelola Peserta Terverifikasi</h1>

    @if($peserta->isEmpty())
        <div class="bg-white p-8 rounded-lg shadow-md text-center">
            <p class="text-gray-500 text-lg">Tidak ada peserta yang terverifikasi saat ini.</p>
        </div>
    @else
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Peserta</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pelatihan</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIK</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status Verifikasi</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Catatan Admin</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peserta as $pendaftaran)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $pendaftaran->nama_lengkap }}</p>
                                <p class="text-gray-600 whitespace-no-wrap">{{ $pendaftaran->email }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $pendaftaran->pelatihan->nama_pelatihan ?? 'N/A' }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $pendaftaran->nik }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="relative inline-block px-3 py-1 font-semibold leading-tight {{ $pendaftaran->status_verifikasi == 'Terverifikasi' ? 'text-green-900' : 'text-red-900' }}">
                                    <span aria-hidden="true" class="absolute inset-0 {{ $pendaftaran->status_verifikasi == 'Terverifikasi' ? 'bg-green-200' : 'bg-red-200' }} opacity-50 rounded-full"></span>
                                    <span class="relative">{{ $pendaftaran->status_verifikasi }}</span>
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $pendaftaran->catatan_admin ?: '-' }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                @if($pendaftaran->url_foto_ktp)
                                    <button @click="showImageModal = true; imageUrl = '{{ Storage::url($pendaftaran->url_foto_ktp) }}'" class="text-blue-600 hover:underline text-xs">Lihat KTP</button><br>
                                @endif
                                @if($pendaftaran->url_foto_ijasah)
                                    <button @click="showImageModal = true; imageUrl = '{{ Storage::url($pendaftaran->url_foto_ijasah) }}'" class="text-blue-600 hover:underline text-xs">Lihat Ijazah</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Image Modal -->
    <div x-show="showImageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50" x-cloak>
        <div class="bg-white rounded-lg p-4 max-w-3xl max-h-full overflow-auto relative">
            <img :src="imageUrl" alt="Dokumen Peserta" class="w-full h-auto">
            <button @click="showImageModal = false" class="absolute top-2 right-2 bg-gray-200 rounded-full p-2 text-gray-700 hover:bg-gray-300">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    </div>
</div>
@endsection
