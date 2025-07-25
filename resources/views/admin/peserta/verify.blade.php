@extends('layouts.admin')

@section('content')
<div x-data="{
    showImageModal: false,
    imageUrl: '',
    showApproveModal: false,
    showRejectModal: false,
    rejectionNote: '',
    showAdminNoteModal: false,
    adminNote: '',
    currentPendaftaran: null, // This will hold the entire pendaftaran object for selected row
    dropdownTop: '0px',
    dropdownLeft: '0px',
    activeDropdownId: null,

    toggleDropdown(event, pendaftaranId, pendaftaran) {
        if (this.activeDropdownId === pendaftaranId) {
            this.activeDropdownId = null;
            this.currentPendaftaran = {};
        } else {
            this.activeDropdownId = pendaftaranId;
            this.currentPendaftaran = pendaftaran;

            const buttonRect = event.currentTarget.getBoundingClientRect();
            this.dropdownTop = window.scrollY + buttonRect.bottom + 5 + 'px';
            this.dropdownLeft = window.scrollX + buttonRect.right - 192 + 'px'; // 192px is w-48
        }
    },

    closeDropdown() {
        this.activeDropdownId = null;
    }
}" class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-4">Daftar Peserta Menunggu Verifikasi</h3>

                {{-- Removed the old success message display block --}}

                @if($peserta->isEmpty())
                    <p>Tidak ada peserta yang menunggu verifikasi saat ini.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Nama Lengkap
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        NIK
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Pelatihan
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Tanggal Daftar
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Foto KTP
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Foto Ijazah
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peserta as $pendaftaran)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ $pendaftaran->nama_lengkap }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ $pendaftaran->nik }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ $pendaftaran->pelatihan->nama_pelatihan ?? 'N/A' }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ $pendaftaran->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            @if($pendaftaran->url_foto_ktp)
                                                <button @click="showImageModal = true; imageUrl = '{{ Storage::url($pendaftaran->url_foto_ktp) }}'" class="text-blue-600 hover:underline text-xs">Lihat KTP</button>
                                            @endif
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            @if($pendaftaran->url_foto_ijasah)
                                                <button @click="showImageModal = true; imageUrl = '{{ Storage::url($pendaftaran->url_foto_ijasah) }}'" class="text-blue-600 hover:underline text-xs">Lihat Ijazah</button>
                                            @endif
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm relative">
                                            <button @click="toggleDropdown($event, {{ $pendaftaran->id }}, {{ $pendaftaran }})" x-ref="btn_{{ $pendaftaran->id }}" class="inline-flex items-center justify-center p-2 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Teleported Dropdown Menu -->
                    <template x-teleport="body">
                        <div x-show="activeDropdownId === currentPendaftaran.id"
                             @click.away="closeDropdown()"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-[1000]"
                             :style="{ top: dropdownTop, left: dropdownLeft }"
                             x-cloak>
                            <div class="py-1" role="menu" aria-orientation="vertical">
                                <a href="#" @click.prevent="showApproveModal = true; closeDropdown()" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    <svg class="h-5 w-5 mr-3 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span>Setujui</span>
                                </a>
                                <a href="#" @click.prevent="showRejectModal = true; rejectionNote = currentPendaftaran.catatan_admin || ''; closeDropdown()" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50" role="menuitem">
                                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2A9 9 0 111 10a9 9 0 0118 0z" /></svg>
                                    <span>Tolak</span>
                                </a>
                                <a href="#" @click.prevent="showAdminNoteModal = true; adminNote = currentPendaftaran.catatan_admin || ''; closeDropdown()" class="flex items-center px-4 py-2 text-sm text-blue-600 hover:bg-blue-50" role="menuitem">
                                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                    <span>Catatan Admin</span>
                                </a>
                            </div>
                        </div>
                    </template>

                    <!-- Image Modal -->
                    <div x-show="showImageModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-[900] flex justify-center items-center" style="display: none;">
                        <div class="relative p-8 bg-white w-full max-w-2xl mx-auto rounded-lg shadow-lg">
                            <button @click="showImageModal = false" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl font-bold">&times;</button>
                            <img :src="imageUrl" alt="Document Image" class="max-w-full h-auto mx-auto">
                        </div>
                    </div>

                    <!-- Approve Modal -->
                    <div x-show="showApproveModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-[900] flex justify-center items-center" style="display: none;">
                        <div class="relative p-8 bg-white w-full max-w-sm mx-auto rounded-lg shadow-lg">
                            <h3 class="text-lg font-semibold mb-4">Konfirmasi Verifikasi</h3>
                            <p class="mb-4">Apakah Anda yakin ingin menyetujui pendaftaran ini?</p>
                            <form x-bind:action="`/admin/verifikasi-peserta/${currentPendaftaran.id}`" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Terverifikasi">
                                <div class="flex justify-end">
                                    <button type="button" @click="showApproveModal = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Batal</button>
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Setujui</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Reject Modal -->
                    <div x-show="showRejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-[900] flex justify-center items-center" style="display: none;">
                        <div class="relative p-8 bg-white w-full max-w-md mx-auto rounded-lg shadow-lg">
                            <h3 class="text-lg font-semibold mb-4">Tolak Peserta</h3>
                            <form x-bind:action="`/admin/verifikasi-peserta/${currentPendaftaran.id}`" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Ditolak">
                                <div class="mb-4">
                                    <label for="rejection_note" class="block text-sm font-medium text-gray-700">Catatan Penolakan (Opsional):</label>
                                    <textarea id="rejection_note" name="catatan_admin" x-model="rejectionNote" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="button" @click="showRejectModal = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Batal</button>
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Tolak</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Admin Note Modal -->
                    <div x-show="showAdminNoteModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-[900] flex justify-center items-center" style="display: none;">
                        <div class="relative p-8 bg-white w-full max-w-md mx-auto rounded-lg shadow-lg">
                            <h3 class="text-lg font-semibold mb-4">Catatan Admin</h3>
                            <form x-bind:action="`/admin/verifikasi-peserta/${currentPendaftaran.id}`" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" x-bind:value="currentPendaftaran ? currentPendaftaran.status_verifikasi : ''"> {{-- Keep current status --}}
                                <div class="mb-4">
                                    <label for="admin_note" class="block text-sm font-medium text-gray-700">Catatan Admin:</label>
                                    <textarea id="admin_note" name="catatan_admin" x-model="adminNote" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="button" @click="showAdminNoteModal = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Batal</button>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Simpan Catatan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
