@extends('layouts.admin')

@section('title', 'Edit Soal')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-bold mb-4">Edit Soal</h2>

<form action="{{ route('admin.soal.update', $materi->materi_id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Program -->
        <div class="mb-4">
            <label for="program_id" class="block text-sm font-medium text-gray-700">Program</label>
            <select name="program_id" id="program_id" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <option value="">-- Pilih Program --</option>
                @foreach($programs as $program)
                    <option value="{{ $program->program_id }}" 
                        {{ $materi->program_id == $program->program_id ? 'selected' : '' }}>
                        {{ $program->title }}
                    </option>
                @endforeach
            </select>
            @error('program_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Soal -->
        <div class="mb-4">
            <label for="soal" class="block text-sm font-medium text-gray-700">Soal</label>
            <textarea name="soal" id="soal" rows="4"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('soal', $materi->soal) }}</textarea>
            @error('soal')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Jawaban -->
        <div class="mb-4">
            <label for="jawaban" class="block text-sm font-medium text-gray-700">Jawaban Benar</label>
            <select name="jawaban" id="jawaban"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <option value="">-- Pilih Jawaban --</option>
                <option value="A" {{ old('jawaban', $materi->jawaban) == 'A' ? 'selected' : '' }}>A</option>
                <option value="B" {{ old('jawaban', $materi->jawaban) == 'B' ? 'selected' : '' }}>B</option>
                <option value="C" {{ old('jawaban', $materi->jawaban) == 'C' ? 'selected' : '' }}>C</option>
                <option value="D" {{ old('jawaban', $materi->jawaban) == 'D' ? 'selected' : '' }}>D</option>
            </select>
            @error('jawaban')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol -->
        <div class="flex justify-end">
            <a href="{{ route('admin.soal.index', ['program_id' => $materi->program_id]) }}" 
               class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 mr-2">
                Batal
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
