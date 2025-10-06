@extends('layouts.admin')

@section('title', 'Tambah Soal')

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Tambah Soal Baru</h2>
        @if($selectedProgramId)
            @php
                $selectedProgram = $programs->firstWhere('program_id', $selectedProgramId);
            @endphp
            <p class="text-sm text-gray-600 mt-1">
                Program: <span class="font-semibold text-blue-600">{{ $selectedProgram->title ?? 'Program tidak ditemukan' }}</span>
            </p>
        @endif
    </div>

    <form action="{{ route('admin.soal.store') }}" method="POST">
        @csrf

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Program</label>
            @if($selectedProgramId)
                <!-- Program sudah dipilih, tampilkan sebagai readonly -->
                <input type="hidden" name="program_id" value="{{ $selectedProgramId }}">
                <div class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-700">
                    {{ $selectedProgram->title ?? 'Program tidak ditemukan' }}
                </div>
            @else
                <!-- Belum memilih program, tampilkan dropdown -->
                <select name="program_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Program --</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->program_id }}" {{ old('program_id') == $program->program_id ? 'selected' : '' }}>
                            {{ $program->title }}
                        </option>
                    @endforeach
                </select>
            @endif
            @error('program_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Soal</label>
            <textarea name="soal" rows="6" 
                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Tulis pertanyaan soal di sini...">{{ old('soal') }}</textarea>
            @error('soal') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Jawaban Benar</label>
            <select name="jawaban" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Pilih Jawaban Benar --</option>
                <option value="A" {{ old('jawaban') == 'A' ? 'selected' : '' }}>A</option>
                <option value="B" {{ old('jawaban') == 'B' ? 'selected' : '' }}>B</option>
                <option value="C" {{ old('jawaban') == 'C' ? 'selected' : '' }}>C</option>
                <option value="D" {{ old('jawaban') == 'D' ? 'selected' : '' }}>D</option>
            </select>
            @error('jawaban') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ $selectedProgramId ? route('admin.soal.index', ['program_id' => $selectedProgramId]) : route('admin.soal.index') }}" 
               class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                Simpan Soal
            </button>
        </div>
    </form>
</div>
@endsection
