<x-app-layout>
    <x-slot name="header">
        {{ $header ?? '' }}
    </x-slot>

    <div {{ $attributes->merge(['class' => 'py-12 bg-gradient-to-b from-white via-[#F2F5FF] to-white']) }}>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </div>
</x-app-layout>

