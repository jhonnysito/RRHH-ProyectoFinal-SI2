@props([
    'texto',
    'textColor' => 'text-gray-700',
    'display' => 'block'
])

<div x-data="{ open: false }" class="relative">
    <button @click="open = !open"
        class="flex justify-between items-center w-full px-4 py-2 text-sm font-semibold {{$textColor}} rounded-lg hover:bg-gray-200 focus:bg-gray-200 focus:outline-none">
        <span>{{ $texto }}</span>
        <svg fill="currentColor" viewBox="0 0 20 20"
            :class="{ 'rotate-180': open, 'rotate-0': !open }"
            class="inline w-4 h-4 transition-transform duration-200 transform">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
        </svg>
    </button>

    <div x-show="open" x-transition class="mt-1 pl-4 pr-2">
        {{ $slot }}
    </div>
</div>
