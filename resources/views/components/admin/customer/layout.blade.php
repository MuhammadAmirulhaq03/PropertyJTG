@props(['selectedTab' => 'crm'])

@php
    $tabs = [
        [
            'key' => 'crm',
            'label' => __('Customer CRM'),
            'description' => __('Data pelanggan, status, dan pengingat dokumen.'),
            'route' => route('admin.crm.index', ['tab' => 'crm']),
        ],
        [
            'key' => 'visit-schedules',
            'label' => __('Kelola Jadwal Kunjungan'),
            'description' => __('Atur jadwal agen, waktu kunjungan, dan catatan khusus.'),
            'route' => route('admin.visit-schedules.index', ['tab' => 'visit-schedules']),
        ],
    ];
@endphp

<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#2563EB]">{{ __('Customer Module') }}</p>
            <h1 class="text-2xl font-bold text-gray-900 md:text-3xl">{{ __('Customer Experience Control Center') }}</h1>
            <p class="text-sm text-gray-500 max-w-2xl">
                {{ __('Kelola CRM pelanggan, verifikasi dokumen, atur jadwal, dan pengingat dari satu tempat terpadu.') }}
            </p>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-4">
        <aside class="lg:col-span-1 space-y-4">
            <nav class="space-y-2 rounded-3xl border border-gray-200 bg-white p-4 shadow-sm">
                @foreach ($tabs as $tab)
                    <a
                        href="{{ $tab['route'] }}"
                        class="block rounded-2xl border px-4 py-3 text-left transition {{ $selectedTab === $tab['key'] ? 'border-[#2563EB] bg-[#2563EB]/10 text-[#1D4ED8]' : 'border-transparent text-gray-600 hover:border-gray-200 hover:bg-gray-50' }}"
                    >
                        <p class="text-sm font-semibold">{{ $tab['label'] }}</p>
                        <p class="text-xs text-gray-500">{{ $tab['description'] }}</p>
                    </a>
                @endforeach
            </nav>
        </aside>

        <section class="lg:col-span-3">
            {{ $slot }}
        </section>
    </div>
</x-admin.layouts.app>
