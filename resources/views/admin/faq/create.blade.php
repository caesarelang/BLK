@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <!-- Form Tambah FAQ -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold leading-tight mb-4">Kelola FAQ</h2>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">Terjadi beberapa kesalahan dengan input Anda.</span>
                    <ul class="mt-2">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.faq.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm">
                @csrf
                <div class="space-y-4">
                    <!-- Pertanyaan -->
                    <div>
                        <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan FAQ Baru</label>
                        <input type="text" name="question" id="question" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('question') }}" placeholder="Tulis pertanyaan FAQ..." required>
                    </div>

                    <!-- Jawaban -->
                    <div>
                        <label for="answer" class="block text-sm font-medium text-gray-700">Jawaban</label>
                        <textarea name="answer" id="answer" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Tulis jawaban untuk pertanyaan di atas..." required>{{ old('answer') }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="reset" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                        Reset
                    </button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Tambah FAQ
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar FAQ yang sudah ada -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Daftar FAQ yang sudah ada</h3>
                <p class="text-sm text-gray-600 mt-1">Total: {{ $faqs->count() }} FAQ</p>
            </div>

            @if($faqs->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($faqs as $index => $faq)
                        <div class="px-6 py-4 hover:bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div class="flex-1 pr-4">
                                    <div class="flex items-center mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                            FAQ #{{ $index + 1 }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ $faq->created_at->format('d M Y, H:i') }}
                                        </span>
                                    </div>
                                    <h4 class="text-md font-semibold text-gray-900 mb-2">
                                        {{ $faq->question }}
                                    </h4>
                                    <p class="text-sm text-gray-700 leading-relaxed">
                                        {{ $faq->answer }}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-2 ml-4">
                                    <a href="{{ route('admin.faq.edit', $faq) }}" 
                                       class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.faq.destroy', $faq) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?')"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada FAQ</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan FAQ pertama menggunakan form di atas.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Auto hide success message after 5 seconds
    setTimeout(function() {
        const successMessage = document.querySelector('.bg-green-100');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 5000);
</script>
@endsection
