<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#2563EB]">{{ __('Kelola Media Properti') }}</p>
            <h1 class="text-2xl font-bold text-gray-900 md:text-3xl">{{ __('Tambah Properti Baru') }}</h1>
            <p class="text-sm text-gray-500 max-w-2xl">
                {{ __('Lengkapi detail listing, unggah media, dan susun deskripsi profesional sebelum ditampilkan di halaman utama.') }}
            </p>
        </div>
    </x-slot>

    @include('admin.properti._form', [
        'property' => $property,
        'types' => $types,
        'segments' => $segments,
        'statuses' => $statuses,
        'mediaLimit' => $mediaLimit,
        'guidelines' => $guidelines,
        'formAction' => route('admin.properties.store'),
    ])
</x-admin.layouts.app>

