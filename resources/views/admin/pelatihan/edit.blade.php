@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div>
            <h2 class="text-2xl font-semibold leading-tight">Edit Program Pelatihan</h2>
        </div>
        <div class="my-5">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">Terjadi beberapa kesalahan dengan input Anda.</span>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <form action="{{ route('admin.programs.update', $program->program_id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-sm">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul Program -->
                <div class="col-span-1">
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Program</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('title', $program->title) }}" required>
                </div>

                <!-- Tanggal Mulai -->
                <div class="col-span-1">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('start_date', $program->start_date->format('Y-m-d')) }}" required>
                </div>

                <!-- Tanggal Selesai -->
                <div class="col-span-1">
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('end_date', $program->end_date->format('Y-m-d')) }}" required>
                </div>

                <!-- Status -->
                <div class="col-span-1">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <option value="Buka" {{ old('status', $program->status) == 'Buka' ? 'selected' : '' }}>Buka</option>
                        <option value="Tutup" {{ old('status', $program->status) == 'Tutup' ? 'selected' : '' }}>Tutup</option>
                    </select>
                </div>

                <!-- Deskripsi -->
                <div class="col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $program->description) }}</textarea>
                </div>

                <!-- Persyaratan -->
                <div class="col-span-2">
                    <label for="requirements" class="block text-sm font-medium text-gray-700">Persyaratan</label>
                    <textarea name="requirements" id="requirements" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('requirements', $program->requirements) }}</textarea>
                </div>
                
                <!-- Gambar Program -->
                <div class="col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700">Ganti Gambar Program (Opsional)</label>
                    <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, GIF, SVG. Maks 2MB.</p>
                    @if($program->image_url)
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700">Gambar Saat Ini:</p>
                            <img src="{{ $program->image_url }}" alt="{{ $program->title }}" class="mt-2 h-32 w-auto rounded-lg">
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.programs.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                    Batal
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
