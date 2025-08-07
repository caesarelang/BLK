@extends('layouts.admin')

@section('content')
<div x-data="{
    showApproveModal: false,
    showRejectModal: false,
    currentRegistration: null,
    dropdownTop: '0px',
    dropdownLeft: '0px',
    activeDropdownId: null,

    toggleDropdown(event, registrationId, registration) {
        if (this.activeDropdownId === registrationId) {
            this.activeDropdownId = null;
        } else {
            this.activeDropdownId = registrationId;
            this.currentRegistration = registration;

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
                <h3 class="text-lg font-semibold mb-4">Daftar Registrasi Menunggu Verifikasi</h3>

                @if($registrations->isEmpty())
                    <p>Tidak ada registrasi yang menunggu verifikasi saat ini.</p>
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
                                        Program Pelatihan
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Nomor Registrasi
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Tanggal Daftar
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrations as $registration)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ $registration->participant->full_name ?? 'N/A' }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ $registration->participant->nik ?? 'N/A' }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ $registration->program->title ?? 'N/A' }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ $registration->registration_number }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{ \Carbon\Carbon::parse($registration->registration_date)->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm relative">
                                            <button @click="toggleDropdown($event, {{ $registration->registration_id }}, {{ json_encode($registration) }})" x-ref="btn_{{ $registration->registration_id }}" class="inline-flex items-center justify-center p-2 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
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
                        <div x-show="activeDropdownId && currentRegistration"
                             @click.away="closeDropdown()"
                             x-transition
                             class="absolute w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-[1000]"
                             :style="{ top: dropdownTop, left: dropdownLeft }"
                             x-cloak>
                            <div class="py-1" role="menu" aria-orientation="vertical">
                                <a href="#" @click.prevent="showApproveModal = true; closeDropdown()" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    <svg class="h-5 w-5 mr-3 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span>Setujui</span>
                                </a>
                                <a href="#" @click.prevent="showRejectModal = true; closeDropdown()" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50" role="menuitem">
                                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2A9 9 0 111 10a9 9 0 0118 0z" /></svg>
                                    <span>Tolak</span>
                                </a>
                            </div>
                        </div>
                    </template>

                    <!-- Approve Modal -->
                    <div x-show="showApproveModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-[900] flex justify-center items-center" style="display: none;">
                        <div class="relative p-8 bg-white w-full max-w-sm mx-auto rounded-lg shadow-lg" @click.away="showApproveModal = false">
                            <h3 class="text-lg font-semibold mb-4">Konfirmasi Verifikasi</h3>
                            <p class="mb-4">Apakah Anda yakin ingin menyetujui registrasi ini?</p>
                            <form :action="`/admin/verify-registrations/${currentRegistration.registration_id}`" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Approved">
                                <div class="flex justify-end">
                                    <button type="button" @click="showApproveModal = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Batal</button>
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Setujui</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Reject Modal -->
                    <div x-show="showRejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-[900] flex justify-center items-center" style="display: none;">
                        <div class="relative p-8 bg-white w-full max-w-md mx-auto rounded-lg shadow-lg" @click.away="showRejectModal = false">
                            <h3 class="text-lg font-semibold mb-4">Tolak Registrasi</h3>
                            <p class="mb-4">Apakah Anda yakin ingin menolak registrasi ini?</p>
                            <form :action="`/admin/verify-registrations/${currentRegistration.registration_id}`" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Rejected">
                                <div class="flex justify-end">
                                    <button type="button" @click="showRejectModal = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Batal</button>
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Tolak</button>
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
