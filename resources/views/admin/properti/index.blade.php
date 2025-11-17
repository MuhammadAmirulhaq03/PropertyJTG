@php
    use Illuminate\Support\Str;
@endphp

<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#2563EB]">
                    {{ __('Kelola Media Properti') }}
                </p>
                <h1 class="text-2xl font-bold text-gray-900 md:text-3xl">
                    {{ __('Smart Listing & Media Manager') }}
                </h1>
                <p class="mt-2 max-w-2xl text-sm text-gray-500">
                    {{ __('Tambahkan, kurasikan, dan tampilkan properti lengkap dengan detail teknis, harga, lokasi, serta galeri foto & video berkualitas tinggi.') }}
                </p>
            </div>
            <a href="{{ route('admin.properties.create') }}"
               class="inline-flex items-center gap-2 rounded-full bg-[#2563EB] px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#1D4ED8]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m6-6H6" />
                </svg>
                {{ __('Tambah Properti') }}
            </a>
        </div>
    </x-slot>

    <div class="space-y-10">
        @if (session('success'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="rounded-3xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                {{ session('warning') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-3xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Total Properti') }}</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
                <p class="text-xs text-gray-500">{{ __('Seluruh aset yang terdaftar di sistem.') }}</p>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-400">{{ __('Dipublikasikan') }}</p>
                <p class="mt-2 text-3xl font-bold text-emerald-600">{{ number_format($stats['published']) }}</p>
                <p class="text-xs text-gray-500">{{ __('Siap tampil di halaman utama.') }}</p>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-amber-400">{{ __('Draft') }}</p>
                <p class="mt-2 text-3xl font-bold text-amber-500">{{ number_format($stats['drafts']) }}</p>
                <p class="text-xs text-gray-500">{{ __('Perlu dilengkapi sebelum dipublikasikan.') }}</p>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Diarsipkan') }}</p>
                <p class="mt-2 text-3xl font-bold text-gray-500">{{ number_format($stats['archived']) }}</p>
                <p class="text-xs text-gray-500">{{ __('Tidak lagi ditampilkan ke pelanggan.') }}</p>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[minmax(0,3fr)_minmax(0,2fr)]">
            <article class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <form method="GET" action="{{ route('admin.properties.index') }}" class="grid gap-4 md:grid-cols-4 md:items-end">
                    <div class="md:col-span-2">
                        <label for="search" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Pencarian') }}</label>
                        <input type="search" id="search" name="search" value="{{ $filters['search'] }}" placeholder="{{ __('Cari nama, lokasi, atau tipe...') }}"
                               class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                    </div>
                    <div>
                        <label for="status" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Status') }}</label>
                        <select id="status" name="status"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                            <option value="all" @selected($filters['status'] === 'all')>{{ __('Semua status') }}</option>
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" @selected($filters['status'] === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="type" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Kategori') }}</label>
                        <select id="type" name="type"
                                class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                            <option value="all" @selected($filters['type'] === 'all')>{{ __('Semua kategori') }}</option>
                            @foreach($types as $key => $label)
                                <option value="{{ $key }}" @selected($filters['type'] === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-4 flex flex-wrap items-center justify-end gap-2">
                        <a href="{{ route('admin.properties.index') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-full border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 transition hover:border-gray-300 hover:text-gray-900">
                            {{ __('Reset') }}
                        </a>
                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-full bg-[#2563EB] px-5 py-2 text-sm font-semibold text-white transition hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4.5h18M6 4.5v4.875a2.25 2.25 0 0 0 .659 1.591L9.75 14.25v5.25l4.5-1.5v-3.75l3.091-3.284A2.25 2.25 0 0 0 18 9.375V4.5" />
                            </svg>
                            {{ __('Terapkan') }}
                        </button>
                    </div>
                </form>

                <div class="mt-8 space-y-6" id="bulk-actions">
    @if($properties->count())
        <div class="flex flex-col gap-3 rounded-3xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
                <label class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-semibold text-gray-600">
                    <input type="checkbox" id="bulk-select-all" class="rounded text-[#2563EB] focus:ring-[#2563EB]">
                    {{ __('Pilih semua') }}
                </label>
                <span id="bulk-selection-count" class="text-xs uppercase tracking-widest text-gray-400">
                    {{ __('0 dipilih') }}
                </span>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="button" data-status="published" class="bulk-action inline-flex items-center gap-2 rounded-full bg-[#2563EB] px-4 py-2 text-xs font-semibold text-white transition hover:-translate-y-0.5 disabled:cursor-not-allowed disabled:opacity-40" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 11l5-5m0 0 5 5m-5-5v12" />
                    </svg>
                    {{ __('Upload ke Galeri') }}
                </button>
                <button type="button" data-status="draft" class="bulk-action inline-flex items-center gap-2 rounded-full border border-amber-200 px-4 py-2 text-xs font-semibold text-amber-600 transition hover:border-amber-300 hover:text-amber-700 disabled:cursor-not-allowed disabled:opacity-40" disabled>
                    {{ __('Tandai Draft') }}
                </button>
                <button type="button" data-status="archived" class="bulk-action inline-flex items-center gap-2 rounded-full border border-gray-300 px-4 py-2 text-xs font-semibold text-gray-600 transition hover:border-gray-400 hover:text-gray-900 disabled:cursor-not-allowed disabled:opacity-40" disabled>
                    {{ __('Arsipkan') }}
                </button>
            </div>
        </div>
    @endif

    <div class="space-y-4" id="property-listings">
        @forelse($properties as $property)
            <div class="relative flex flex-col gap-6 rounded-3xl border border-gray-100 bg-gray-50/80 p-6 shadow-sm transition hover:border-[#2563EB]/40 hover:shadow-lg md:flex-row md:items-start" data-property-card>
                <div class="absolute right-5 top-5 z-20">
                    <label class="inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-gray-600 shadow">
                        <input type="checkbox" form="bulk-status-form" name="property_ids[]" value="{{ $property->id }}" class="property-select rounded text-[#2563EB] focus:ring-[#2563EB]">
                        {{ __('Pilih') }}
                    </label>
                </div>
                <div class="w-full md:w-48">
                    @if($property->primaryMedia)
                        <div class="relative overflow-hidden rounded-2xl bg-gray-200">
                            <img src="{{ $property->primaryMedia->url }}"
                                 alt="{{ $property->primaryMedia->caption ?? $property->nama }}"
                                 class="h-36 w-full object-cover">
                            <span class="absolute left-2 top-2 inline-flex items-center gap-1 rounded-full bg-white/80 px-3 py-1 text-[11px] font-semibold text-[#2563EB] shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.5l3.09 6.26 6.91 1-5 4.87 1.18 6.87L12 21l-6.18 3.5L7 18.63 2 13.76l6.91-1z" />
                                </svg>
                                {{ __('Media Utama') }}
                            </span>
                        </div>
                    @else
                        <div class="flex h-36 w-full items-center justify-center rounded-2xl border border-dashed border-gray-300 bg-white text-xs text-gray-400">
                            {{ __('Belum ada media') }}
                        </div>
                    @endif
                </div>

                <div class="flex-1 space-y-3">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-lg font-semibold text-gray-900">{{ $property->nama }}</h2>
                            <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 text-xs font-semibold text-gray-600">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                {{ $segments[$property->tipe] ?? Str::title($property->tipe) }}
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 text-xs font-semibold text-gray-600">
                                <span class="h-2 w-2 rounded-full bg-[#2563EB]"></span>
                                {{ $types[$property->tipe_properti] ?? Str::title($property->tipe_properti) }}
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full {{ match($property->status) {
                                    'published' => 'bg-emerald-50 text-emerald-700',
                                    'draft' => 'bg-amber-50 text-amber-600',
                                    default => 'bg-gray-200 text-gray-600',
                                } }} px-3 py-1 text-xs font-semibold">
                                {{ $statuses[$property->status] ?? Str::title($property->status) }}
                            </span>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            {{ $property->lokasi }}
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        <div class="rounded-2xl bg-white px-4 py-3 text-sm text-gray-600">
                            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Harga Listing') }}</p>
                            <p class="mt-1 text-lg font-bold text-gray-900">Rp {{ number_format($property->harga, 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-2xl bg-white px-4 py-3 text-sm text-gray-600">
                            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Unit Tersedia') }}</p>
                            <p class="mt-1 font-semibold text-gray-900">
                                @if(is_null($property->units_available))
                                    <span class="text-gray-400">{{ __('Belum diisi') }}</span>
                                @else
                                    {{ $property->units_available }} {{ __('unit') }}
                                @endif
                            </p>
                        </div>
                        <div class="rounded-2xl bg-white px-4 py-3 text-sm text-gray-600">
                            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Media') }}</p>
                            <p class="mt-1 font-semibold text-gray-900">
                                {{ $property->media->where('media_type', 'image')->count() }} {{ __('Foto') }},
                                {{ $property->media->where('media_type', 'video')->count() }} {{ __('Video') }}
                            </p>
                        </div>
                        <div class="rounded-2xl bg-white px-4 py-3 text-sm text-gray-600">
                            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Diperbarui') }}</p>
                            <p class="mt-1 font-semibold text-gray-900">{{ $property->updated_at->translatedFormat('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    @if($property->deskripsi)
                        <p class="rounded-2xl bg-white px-4 py-3 text-sm leading-relaxed text-gray-600 line-clamp-3">
                            {{ Str::limit($property->deskripsi, 240) }}
                        </p>
                    @endif

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.properties.edit', $property) }}"
                           class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-4 py-2 text-xs font-semibold text-gray-600 transition hover:border-gray-300 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                            </svg>
                            {{ __('Kelola') }}
                        </a>
                        <form id="delete-property-{{ $property->id }}" method="POST" action="{{ route('admin.properties.destroy', $property) }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" data-confirm-form="delete-property-{{ $property->id }}" data-confirm-title="{{ __('Hapus properti ini?') }}" data-confirm-message="{{ __('Seluruh media terkait akan ikut terhapus. Tindakan ini tidak dapat dibatalkan.') }}"
                                    class="inline-flex items-center gap-2 rounded-full border border-red-200 px-4 py-2 text-xs font-semibold text-red-600 transition hover:border-red-300 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ __('Hapus') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center gap-4 rounded-3xl border border-dashed border-gray-300 bg-white px-6 py-12 text-center">
                <img src="https://illustrations.popsy.co/gray/space.svg" alt="" class="h-32 w-32">
                <div class="space-y-2">
                    <p class="text-lg font-semibold text-gray-900">{{ __('Belum ada properti yang terdaftar.') }}</p>
                    <p class="text-sm text-gray-500">
                        {{ __('Mulai tambah properti baru lengkap dengan detail dan media untuk ditampilkan ke pelanggan.') }}
                    </p>
                </div>
                <a href="{{ route('admin.properties.create') }}"
                   class="inline-flex items-center gap-2 rounded-full bg-[#2563EB] px-5 py-2 text-sm font-semibold text-white transition hover:-translate-y-0.5">
                    {{ __('Tambah Properti Pertama') }}
                </a>
            </div>
        @endforelse
    </div>
</div>

<div class="mt-6">
    {{ $properties->links() }}
</div>

<form id="bulk-status-form" method="POST" action="{{ route('admin.properties.bulk-status') }}" class="hidden">
    @csrf
    <input type="hidden" name="target_status" id="bulk-status-action">
</form>

            </article>

            <aside class="space-y-6">
                <div class="rounded-3xl border border-[#2563EB]/20 bg-[#2563EB]/5 p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-[#1D4ED8]">{{ __('Panduan Media Unggulan') }}</h2>
                    <p class="mt-2 text-sm text-[#1D4ED8]/80">
                        {{ __('Pastikan semua media memenuhi standar kualitas agar tampilan listing konsisten dan menarik.') }}
                    </p>
                    <ul class="mt-4 space-y-3 text-sm text-[#1D4ED8]/80">
                        @foreach($guidelines as $guide)
                            <li class="flex items-start gap-3">
                                <span class="mt-1 inline-flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-white text-xs font-semibold text-[#2563EB] shadow">
                                    {{ $loop->iteration }}
                                </span>
                                <span>{{ $guide }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('Limitasi Upload') }}</h2>
                    <p class="mt-2 text-sm text-gray-500">
                        {{ __('Maksimal :limit file media per properti dengan ukuran per file hingga 50MB.', ['limit' => $mediaLimit]) }}
                    </p>
                    <p class="mt-4 text-sm text-gray-500">
                        {{ __('Gunakan caption untuk menyoroti ruangan, fasilitas, atau keunggulan properti yang perlu ditonjolkan.') }}
                    </p>
                </div>
            </aside>
        </section>
    </div>
</x-admin.layouts.app>

<!-- Confirm Delete Property Modal (blue theme) -->
<div id="confirm-delete-property-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
    <div class="fixed inset-0 flex min-h-full items-end sm:items-center justify-center p-4 sm:p-6">
        <div id="confirm-property-panel" class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 ring-1 ring-[#2563EB]/20">
            <div class="px-6 pt-6">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#2563EB]/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2563EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 110-18 9 9 0 010 18z" />
                    </svg>
                </div>
                <h3 id="confirm-property-title" class="mt-4 text-lg font-semibold text-gray-900">{{ __('Hapus properti?') }}</h3>
                <p id="confirm-property-message" class="mt-2 text-sm leading-relaxed text-gray-600">{{ __('Proses ini akan menghapus properti beserta semua media yang terkait. Lanjutkan?') }}</p>
            </div>
            <div class="mt-6 flex items-center justify-end gap-3 border-t border-gray-100 px-6 py-4 bg-gray-50">
                <button type="button" id="confirm-property-cancel" class="inline-flex justify-center rounded-full border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">{{ __('Batal') }}</button>
                <button type="button" id="confirm-property-submit" class="inline-flex justify-center rounded-full bg-[#2563EB] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#1D4ED8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2563EB]">{{ __('Hapus') }}</button>
            </div>
        </div>
    </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('bulk-status-form');
        const bulkContainer = document.getElementById('bulk-actions');
        if (!form || !bulkContainer) {
            return;
        }

        const selectAll = document.getElementById('bulk-select-all');
        const selectionCount = document.getElementById('bulk-selection-count');
        const actionButtons = Array.from(bulkContainer.querySelectorAll('.bulk-action'));
        const hiddenStatus = document.getElementById('bulk-status-action');
        const checkboxSelector = 'input[name="property_ids[]"][form="bulk-status-form"]';
        const checkboxes = () => Array.from(document.querySelectorAll(checkboxSelector));

        const selectionWarning = document.createElement('p');
        selectionWarning.className = 'text-xs font-semibold text-red-500 hidden';
        selectionWarning.textContent = '{{ __('Pilih minimal satu properti terlebih dahulu.') }}';
        bulkContainer.prepend(selectionWarning);

        const updateState = () => {
            const selected = checkboxes().filter((checkbox) => checkbox.checked);
            const hasSelection = selected.length > 0;

            if (selectionCount) {
                selectionCount.textContent = selected.length + ' {{ __('dipilih') }}';
            }

            actionButtons.forEach((button) => {
                if (hasSelection) {
                    button.removeAttribute('disabled');
                } else {
                    button.setAttribute('disabled', 'disabled');
                }
            });

            if (hasSelection) {
                selectionWarning.classList.add('hidden');
            }

            if (selectAll) {
                const total = checkboxes().length;
                selectAll.checked = total > 0 && selected.length === total;
            }
        };

        actionButtons.forEach((button) => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                if (!hiddenStatus) {
                    return;
                }

                const status = button.getAttribute('data-status');
                if (!status) {
                    return;
                }

                const anySelected = checkboxes().some((checkbox) => checkbox.checked);
                if (!anySelected) {
                    selectionWarning.classList.remove('hidden');
                    return;
                }

                selectionWarning.classList.add('hidden');
                hiddenStatus.value = status;
                if (typeof form.requestSubmit === 'function') {
                    form.requestSubmit();
                } else {
                    form.submit();
                }
            });
        });

        selectAll?.addEventListener('change', () => {
            const checked = Boolean(selectAll.checked);
            checkboxes().forEach((checkbox) => {
                checkbox.checked = checked;
            });
            updateState();
        });

        document.addEventListener('change', (event) => {
            if (event.target instanceof HTMLInputElement && event.target.matches(checkboxSelector)) {
                updateState();
            }
        });

        updateState();
    });
</script>
<script>
    // Blue confirmation modal for deleting property rows
    (function () {
        const modal = document.getElementById('confirm-delete-property-modal');
        const panel = document.getElementById('confirm-property-panel');
        const title = document.getElementById('confirm-property-title');
        const message = document.getElementById('confirm-property-message');
        const btnCancel = document.getElementById('confirm-property-cancel');
        const btnSubmit = document.getElementById('confirm-property-submit');
        let targetFormId = null;

        function openModal(opts) {
            targetFormId = opts.formId;
            if (opts.title) title.textContent = opts.title;
            if (opts.message) message.textContent = opts.message;
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            requestAnimationFrame(() => {
                panel.classList.remove('opacity-0', 'translate-y-4', 'sm:scale-95');
            });
            btnSubmit.focus();
        }

        function closeModal() {
            panel.classList.add('opacity-0', 'translate-y-4', 'sm:scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
                targetFormId = null;
            }, 150);
        }

        document.addEventListener('click', function (e) {
            const trigger = e.target.closest('[data-confirm-form]');
            if (trigger) {
                e.preventDefault();
                openModal({
                    formId: trigger.getAttribute('data-confirm-form'),
                    title: trigger.getAttribute('data-confirm-title') || title.textContent,
                    message: trigger.getAttribute('data-confirm-message') || message.textContent,
                });
            }
        });

        btnCancel.addEventListener('click', closeModal);
        modal.addEventListener('click', function (e) {
            if (e.target === modal) closeModal();
        });
        btnSubmit.addEventListener('click', function () {
            if (!targetFormId) return closeModal();
            const form = document.getElementById(targetFormId);
            if (form) form.submit();
            closeModal();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
        });
    })();
</script>
