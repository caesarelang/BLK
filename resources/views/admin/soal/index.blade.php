@extends('layouts.admin')

@section('title', 'Kelola Soal')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-4">Kelola Soal</h2>
        
        <!-- Filter Program -->
        <form method="GET" action="{{ route('admin.soal.index') }}" class="mb-4">
            <div class="flex items-center gap-4">
                <div class="flex-1">
                    <label for="program_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Program untuk Mengelola Soal:
                    </label>
                    <select name="program_id" id="program_id" onchange="this.form.submit()" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Program --</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->program_id }}" {{ $selectedProgramId == $program->program_id ? 'selected' : '' }}>
                                {{ $program->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>

    @if($selectedProgram)
        <!-- Header untuk program yang dipilih -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-blue-900">Soal untuk Program: {{ $selectedProgram->title }}</h3>
                    <p class="text-sm text-blue-700 mt-1">Total: {{ $materi->total() }} soal</p>
                </div>
                <a href="{{ route('admin.soal.create', ['program_id' => $selectedProgramId]) }}" 
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Soal
                </a>
            </div>
        </div>

        @if($materi->count() > 0)
            <!-- Tabel Soal -->
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 border-b font-semibold">No</th>
                            <th class="px-4 py-3 border-b font-semibold">Soal</th>
                            <th class="px-4 py-3 border-b font-semibold">Jawaban Benar</th>
                            <th class="px-4 py-3 border-b font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materi as $index => $row)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3 w-16">{{ $materi->firstItem() + $index }}</td>
                                <td class="px-4 py-3">
                                    <div class="max-w-md">
                                        {{ Str::limit($row->soal, 100) }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $row->jawaban }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.soal.edit', $row->materi_id) }}" 
                                           class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                        <form action="{{ route('admin.soal.destroy', $row->materi_id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium" 
                                                    onclick="return confirm('Hapus soal ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $materi->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Empty state untuk program yang dipilih -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada soal</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan soal pertama untuk program ini.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.soal.create', ['program_id' => $selectedProgramId]) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Tambah Soal Pertama
                    </a>
                </div>
            </div>
        @endif
    @else
        <!-- State awal ketika belum memilih program -->
        <div class="text-center py-16">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Pilih Program Terlebih Dahulu</h3>
            <p class="mt-2 text-sm text-gray-500">
                Untuk mengelola soal, silakan pilih program pelatihan yang ingin Anda kelola soalnya dari dropdown di atas.
            </p>
        </div>
    @endif

    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif
</div>

<script>
    // Auto hide success message after 3 seconds
    setTimeout(function() {
        const successMessage = document.querySelector('.fixed.bottom-4');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 3000);
</script>
@endsection
