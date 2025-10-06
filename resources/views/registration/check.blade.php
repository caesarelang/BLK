@extends('layouts.app-v2')

@section('title', 'Cek Status Registrasi')

@section('content')
<div class="max-w-xl mx-auto px-4 py-12">
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white text-center py-4">
            <h2 class="text-xl font-bold flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="h-6 w-6 mr-2" fill="none" 
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                </svg>
                Cek Status Registrasi
            </h2>
        </div>

        <!-- Body -->
        <div class="p-6">
            {{-- Alert error --}}
            @if(session('error'))
                <div class="mb-4 rounded-lg bg-red-100 border border-red-300 text-red-700 p-3 flex items-start justify-between">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-5 w-5 mr-2 text-red-600" 
                             viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" 
                                  d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 
                                  8-8 8 3.582 8 8zm-7-4a1 1 0 11-2 0 1 1 0 012 
                                  0zm-1 2a1 1 0 00-1 1v4a1 1 0 102 0v-4a1 
                                  1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" class="ml-4 text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">
                        ✕
                    </button>
                </div>
            @endif

            <form method="POST" action="{{ route('registration.check') }}" id="registrationForm">
                @csrf
                <div class="mb-5">
                    <label for="reg_number" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nomor Registrasi
                    </label>
                    <input type="text" 
                           name="reg_number" 
                           id="reg_number"
                           class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('reg_number') border-red-500 @enderror"
                           value="{{ old('reg_number') }}" 
                           placeholder="Masukkan nomor registrasi anda" 
                           required>
                    @error('reg_number')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-md transition-transform transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         class="h-5 w-5 inline-block mr-1" 
                         viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" 
                              d="M16.707 5.293a1 1 0 010 1.414l-7.364 7.364a1 1 0 
                              01-1.414 0L3.293 9.414a1 1 0 011.414-1.414l4.222 
                              4.222 6.657-6.657a1 1 0 011.414 0z" 
                              clip-rule="evenodd" />
                    </svg>
                    Cek Status
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 text-center text-sm text-gray-600 py-3">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="h-4 w-4 inline-block mr-1 text-gray-500" 
                 viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" 
                      d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 
                      8-8 8 3.582 8 8zm-8-4a1 1 0 100 
                      2 1 1 0 000-2zm1 4a1 1 0 10-2 
                      0v4a1 1 0 102 0v-4z" 
                      clip-rule="evenodd" />
            </svg>
            Masukkan nomor registrasi yang Anda terima saat pendaftaran
        </div>
    </div>
</div>
@endsection
