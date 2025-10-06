@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div>
            <h2 class="text-2xl font-semibold leading-tight">Edit FAQ</h2>
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
        <form action="{{ route('admin.faq.update', $faq) }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <!-- Pertanyaan -->
                <div>
                    <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                    <input type="text" name="question" id="question" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('question', $faq->question) }}" required>
                </div>

                <!-- Jawaban -->
                <div>
                    <label for="answer" class="block text-sm font-medium text-gray-700">Jawaban</label>
                    <textarea name="answer" id="answer" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>{{ old('answer', $faq->answer) }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.faq.create') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded mr-2">
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
