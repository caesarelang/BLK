@extends('layouts.app-v2')

@section('content')
<div class="min-h-screen bg-gray-100 py-6">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-6 text-center">Form Pendaftaran Program</h2>

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form id="registrationForm" 
                  method="POST" 
                  action="{{ route('registration.submit') }}" 
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                <!-- Program Selection -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold mb-4">Program Pelatihan</h3>
                    <select name="program_id" required class="w-full rounded-md border-gray-300">
                        <option value="">Pilih Program</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->program_id }}">{{ $program->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Personal Data -->
                <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                    <h3 class="font-semibold mb-4">Data Pribadi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- NIK -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">NIK</label>
                            <input type="text" 
                                   name="nik" 
                                   value="{{ old('nik') }}"
                                   required 
                                   pattern="[0-9]{16}"
                                   class="mt-1 w-full rounded-md border-gray-300">
                        </div>

                        <!-- Full Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" 
                                   name="full_name" 
                                   value="{{ old('full_name') }}"
                                   required 
                                   class="mt-1 w-full rounded-md border-gray-300">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required 
                                   class="mt-1 w-full rounded-md border-gray-300">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                            <input type="tel" 
                                   name="phone_number" 
                                   value="{{ old('phone_number') }}"
                                   required 
                                   pattern="[0-9]{10,15}"
                                   class="mt-1 w-full rounded-md border-gray-300">
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                            <input type="date" 
                                   name="date_of_birth" 
                                   value="{{ old('date_of_birth') }}"
                                   required 
                                   max="{{ date('Y-m-d') }}"
                                   class="mt-1 w-full rounded-md border-gray-300">
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                            <select name="jenis_kelamin" required class="mt-1 w-full rounded-md border-gray-300">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <!-- Education -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pendidikan Terakhir</label>
                            <select name="last_education" required class="mt-1 w-full rounded-md border-gray-300">
                                <option value="">Pilih Pendidikan</option>
                                @foreach(['SD', 'SMP', 'SMA', 'SMK', 'D3', 'S1', 'S2', 'S3'] as $edu)
                                    <option value="{{ $edu }}">{{ $edu }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <textarea name="address" 
                                  required 
                                  rows="3" 
                                  class="mt-1 w-full rounded-md border-gray-300">{{ old('address') }}</textarea>
                    </div>
                </div>

                <!-- Documents -->
                <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                    <h3 class="font-semibold mb-4">Upload Dokumen</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- KTP -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Foto KTP</label>
                            <input type="file" 
                                   name="ktp_file" 
                                   required 
                                   accept="image/jpeg,image/png"
                                   class="mt-1 w-full">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG, max 2MB</p>
                        </div>

                        <!-- Photo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pas Foto</label>
                            <input type="file" 
                                   name="pas_foto_file" 
                                   required 
                                   accept="image/jpeg,image/png"
                                   class="mt-1 w-full">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG, max 2MB</p>
                        </div>

                        <!-- Certificate -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ijazah Terakhir</label>
                            <input type="file" 
                                   name="ijazah_file" 
                                   required 
                                   accept="image/jpeg,image/png"
                                   class="mt-1 w-full">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG, max 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                                       <!-- Login Button -->
                    <a href="/login" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg text-center transition duration-300 ease-in-out">
                        Login
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                        Daftar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (this.checkValidity()) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Memproses...';
            this.submit();
        }
    });
});
</script>
@endpush