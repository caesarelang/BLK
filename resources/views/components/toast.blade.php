@props(['message', 'type' => 'success'])

@php
    $colors = [
        'success' => 'bg-green-100 border-green-400 text-green-700',
        'error' => 'bg-red-100 border-red-400 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
        'info' => 'bg-blue-100 border-blue-400 text-blue-700',
    ];
@endphp

<div x-data="{ show: true }"
     x-init="setTimeout(() => show = false, 5000)"
     x-show="show"
     x-transition:enter="transform ease-out duration-300 transition"
     x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
     x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
     x-transition:leave="transition ease-in duration-100"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed top-5 right-5 w-full max-w-sm p-4 border-l-4 rounded-md shadow-lg z-[100] {{ $colors[$type] }}"
     role="alert">
    
    <div class="flex">
        <div class="py-1">
            {{-- Icons can be added here for different types --}}
        </div>
        <div>
            <p class="font-bold">{{ ucfirst($type) }}</p>
            <p class="text-sm">{{ $message }}</p>
        </div>
    </div>
</div>
