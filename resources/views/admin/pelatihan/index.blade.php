@extends('layouts.admin')

@section('content')
@if(session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-full" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform translate-x-full" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-xl z-[9999]">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

<div x-data="{
    showCreateModal: false,
    showEditModal: false,
    showDeleteModal: false,
    currentPelatihan: {},
    newPelatihan: {
        nama_pelatihan: '',
        deskripsi: '',
        tanggal_mulai: '',
        tanggal_berakhir: '',
        lokasi: '',
        kuota: 10
    },
    formatDateForInput(date) {
        if (!date) return '';
        return new Date(date).toISOString().split('T')[0];
    },
    dropdownTop: '0px',
    dropdownLeft: '0px',
    activeDropdownId: null,

    toggleDropdown(event, pelatihanId, pelatihan) {
        if (this.activeDropdownId === pelatihanId) {
            this.activeDropdownId = null;
            this.currentPelatihan = {};
        } else {
            this.activeDropdownId = pelatihanId;
            this.currentPelatihan = pelatihan;

            const buttonRect = event.currentTarget.getBoundingClientRect();
            this.dropdownTop = window.scrollY + buttonRect.bottom + 5 + 'px';
            this.dropdownLeft = window.scrollX + buttonRect.right - 192 + 'px'; // 192px is w-48
        }
    },

    closeDropdown() {
        this.activeDropdownId = null;
    }
}" class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold leading-tight">Kelola Pelatihan</h2>
            <button @click="showCreateModal = true" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                Tambah Pelatihan
            </button>
        </div>

        <!-- Modern Table-based List without Images -->
        <div class="inline-block min-w-full shadow-lg rounded-lg">
            <table class="min-w-full leading-normal">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelatihan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kuota</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pelatihans as $pelatihan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $pelatihan->nama_pelatihan }}</div>
                                <div class="text-xs text-gray-500 truncate max-w-xs">{{ $pelatihan->deskripsi }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $pelatihan->lokasi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $pelatihan->kuota }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium relative">
                               <button @click="toggleDropdown($event, {{ $pelatihan->id_pelatihan }}, {{ $pelatihan }})" x-ref="btn_{{ $pelatihan->id_pelatihan }}" class="inline-flex items-center justify-center p-2 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12">
                                <p class="text-gray-500 text-lg">Belum ada data pelatihan yang ditambahkan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Teleported Dropdown Menu -->
    <template x-teleport="body">
        <div x-show="activeDropdownId === currentPelatihan.id_pelatihan"
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
                <a href="#" @click.prevent="showEditModal = true; closeDropdown()" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                    <svg class="h-5 w-5 mr-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536l12.232-12.232z" /></svg>
                    <span>Edit</span>
                </a>
                <a href="#" @click.prevent="showDeleteModal = true; closeDropdown()" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50" role="menuitem">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    <span>Hapus</span>
                </a>
            </div>
        </div>
    </template>

    <!-- Modals (Create, Edit, Delete) - Image URL field removed -->
     <div x-show="showCreateModal || showEditModal" 
         class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak>
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl mx-4" 
             @click.away="showCreateModal = false; showEditModal = false"
             x-show="showCreateModal || showEditModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <div class="px-6 py-4 border-b">
                <h2 class="text-2xl font-bold" x-text="showCreateModal ? 'Tambah Pelatihan Baru' : 'Edit Pelatihan'"></h2>
            </div>

            <form :action="showCreateModal ? '{{ route('admin.pelatihan.store') }}' : `/admin/pelatihan/${currentPelatihan.id_pelatihan}`" method="POST" class="p-6">
                @csrf
                <template x-if="showEditModal">
                    @method('PUT')
                </template>
                
                <div class="space-y-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Pelatihan</label>
                        <input type="text" :name="'nama_pelatihan'" x-model="showCreateModal ? newPelatihan.nama_pelatihan : currentPelatihan.nama_pelatihan" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                        <textarea :name="'deskripsi'" x-model="showCreateModal ? newPelatihan.deskripsi : currentPelatihan.deskripsi" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4"></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Mulai</label>
                            <input type="date" :name="'tanggal_mulai'" :value="showCreateModal ? newPelatihan.tanggal_mulai : formatDateForInput(currentPelatihan.tanggal_mulai)" @input="showEditModal ? currentPelatihan.tanggal_mulai = $event.target.value : newPelatihan.tanggal_mulai = $event.target.value" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Berakhir</label>
                            <input type="date" :name="'tanggal_berakhir'" :value="showCreateModal ? newPelatihan.tanggal_berakhir : formatDateForInput(currentPelatihan.tanggal_berakhir)" @input="showEditModal ? currentPelatihan.tanggal_berakhir = $event.target.value : newPelatihan.tanggal_berakhir = $event.target.value" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Lokasi</label>
                            <input type="text" :name="'lokasi'" x-model="showCreateModal ? newPelatihan.lokasi : currentPelatihan.lokasi" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Kuota</label>
                            <input type="number" :name="'kuota'" x-model="showCreateModal ? newPelatihan.kuota : currentPelatihan.kuota" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 text-right mt-6 -mx-6 -mb-6 rounded-b-lg">
                    <button type="button" @click="showCreateModal = false; showEditModal = false" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-md mr-2 transition-colors">Batal</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors" x-text="showCreateModal ? 'Simpan' : 'Perbarui'"></button>
                </div>
            </form>
        </div>
    </div>


    <!-- Delete Modal -->
    <div x-show="showDeleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md mx-4" @click.away="showDeleteModal = false">
            <div class="text-center">
                 <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-5">Hapus Pelatihan</h3>
                <div class="mt-2 px-7 py-3">
                     <p class="text-sm text-gray-500">Anda yakin ingin menghapus pelatihan <strong x-text="currentPelatihan.nama_pelatihan"></strong>? Tindakan ini tidak dapat diurungkan.</p>
                </div>
            </div>
            <div class="flex justify-center mt-6">
                <form :action="`/admin/pelatihan/${currentPelatihan.id_pelatihan}`" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="showDeleteModal = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-md mr-2 transition-colors">Batal</button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md transition-colors">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
