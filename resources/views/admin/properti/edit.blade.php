<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#2563EB]">{{ __('Kelola Media Properti') }}</p>
                <h1 class="text-2xl font-bold text-gray-900 md:text-3xl">{{ __('Perbarui Properti') }}</h1>
                <p class="text-sm text-gray-500 max-w-2xl">
                    {{ __('Optimalkan detail listing dan susun ulang galeri media agar tampil maksimal di halaman utama.') }}
                </p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1 font-semibold text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3" />
                    </svg>
                    {{ __('Terakhir diperbarui :timestamp', ['timestamp' => $property->updated_at->diffForHumans()]) }}
                </span>
            </div>
        </div>
    </x-slot>

    @include('admin.properti._form', [
        'property' => $property,
        'types' => $types,
        'segments' => $segments,
        'statuses' => $statuses,
        'mediaLimit' => $mediaLimit,
        'guidelines' => $guidelines,
        'formAction' => route('admin.properties.update', $property),
        'formMethod' => 'PUT',
    ])
</x-admin.layouts.app>

