@extends('layouts.app-v2')

@section('content')
<main class="flex-grow">
    <section class="my-12 max-w-2xl mx-auto px-4">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-extrabold text-center mb-2 text-dark">Langkah 2: Info Tambahan</h1>
            <p class="text-center text-gray-600 mb-8">Lengkapi informasi alamat dan pilih program pelatihan.</p>

             @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('registration.store.step2') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="date_of_birth" class="block text-dark text-sm font-bold mb-2">Tanggal Lahir</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $data['date_of_birth'] ?? '') }}"
                           class="shadow appearance-none border rounded w-full py-3 px-4 text-dark leading-tight focus:outline-none focus:shadow-outline @error('date_of_birth') border-red-500 @enderror" required>
                    @error('date_of_birth')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="address" class="block text-dark text-sm font-bold mb-2">Alamat Lengkap</label>
                    <textarea name="address" id="address" rows="3"
                              class="shadow appearance-none border rounded w-full py-3 px-4 text-dark leading-tight focus:outline-none focus:shadow-outline @error('address') border-red-500 @enderror"
                              placeholder="Alamat sesuai KTP..." required>{{ old('address', $data['address'] ?? '') }}</textarea>
                    @error('address')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="program_id" class="block text-dark text-sm font-bold mb-2">Pilih Program</label>
                    <select name="program_id" id="program_id"
                            class="shadow appearance-none border rounded w-full py-3 px-4 text-dark leading-tight focus:outline-none focus:shadow-outline @error('program_id') border-red-500 @enderror" required>
                        <option value="" disabled {{ !isset($data['program_id']) ? 'selected' : '' }}>-- Pilih Program Pelatihan --</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->program_id }}" {{ (old('program_id', $data['program_id'] ?? '') == $program->program_id) ? 'selected' : '' }}>
                                {{ $program->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('program_id')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="last_education" class="block text-dark text-sm font-bold mb-2">Pendidikan Terakhir</label>
                    <select name="last_education" id="last_education"
                            class="shadow appearance-none border rounded w-full py-3 px-4 text-dark leading-tight focus:outline-none focus:shadow-outline @error('last_education') border-red-500 @enderror" required>
                        <option value="" disabled {{ !isset($data['last_education']) ? 'selected' : '' }}>-- Pilih Pendidikan --</option>
                        <option value="SMP/Sederajat" {{ (old('last_education', $data['last_education'] ?? '') == 'SMP/Sederajat') ? 'selected' : '' }}>SMP/Sederajat</option>
                        <option value="SMA/SMK/Sederajat" {{ (old('last_education', $data['last_education'] ?? '') == 'SMA/SMK/Sederajat') ? 'selected' : '' }}>SMA/SMK/Sederajat</option>
                        <option value="Diploma" {{ (old('last_education', $data['last_education'] ?? '') == 'Diploma') ? 'selected' : '' }}>Diploma</option>
                        <option value="Sarjana" {{ (old('last_education', $data['last_education'] ?? '') == 'Sarjana') ? 'selected' : '' }}>Sarjana</option>
                        <option value="Lainnya" {{ (old('last_education', $data['last_education'] ?? '') == 'Lainnya') ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('last_education')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-between pt-4">
                    <a href="{{ route('registration.create.step1') }}" class="text-sm text-gray-600 hover:text-dark">&larr; Kembali</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-transform transform hover:scale-105">
                        Lanjutkan &rarr;
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection
