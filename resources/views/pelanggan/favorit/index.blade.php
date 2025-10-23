<x-app-layout>
    <section class="bg-[#FFF5EE] min-h-screen py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[280px_minmax(0,1fr)]">
                @php
                    $types = $types ?? [
                        'residensial' => 'Residensial',
                        'komersial' => 'Komersial',
                        'apartemen' => 'Apartemen',
                        'tanah' => 'Tanah Kosong',
                        'lainnya' => 'Lainnya',
                    ];
                @endphp
                <aside class="overflow-hidden rounded-3xl border border-[#FFDCC4] bg-white shadow-md">
                    <div class="bg-[#DB4437] px-6 py-6 text-white">
                        <p class="text-xs font-semibold uppercase tracking-widest">Customer Journey</p>
                        <p class="mt-1 text-xl font-bold">{{ __('Properti Favorit') }}</p>
                        <p class="mt-3 text-sm opacity-80">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <nav class="space-y-2 px-5 py-6 text-sm text-gray-600">
                        @php
                            $customerLinks = [
                                ['label' => __('Customer Dashboard'), 'route' => route('dashboard'), 'active' => request()->routeIs('dashboard')],
                                ['label' => __('Home Page'), 'route' => route('homepage'), 'active' => request()->routeIs('homepage')],
                                ['label' => __('Document'), 'route' => route('documents.index'), 'active' => request()->routeIs('documents.*')],
                                ['label' => __('Feedback'), 'route' => route('pelanggan.feedback.create'), 'active' => request()->routeIs('pelanggan.feedback.*')],
                                ['label' => __('Konsultan Properti'), 'route' => route('pelanggan.consultants.create'), 'active' => request()->routeIs('pelanggan.consultants.*')],
                                ['label' => __('Pemesanan Kontraktor'), 'route' => route('pelanggan.contractors.create'), 'active' => request()->routeIs('pelanggan.contractors.*')],
                                ['label' => __('Jadwal Kunjungan'), 'route' => route('pelanggan.jadwal.index'), 'active' => request()->routeIs('pelanggan.jadwal.*')],
                                ['label' => __('Kalkulator KPR'), 'route' => route('pelanggan.kpr.show'), 'active' => request()->routeIs('pelanggan.kpr.*')],
                                ['label' => __('Favorit'), 'route' => route('pelanggan.favorit.index'), 'active' => request()->routeIs('pelanggan.favorit.*')],
                            ];
                        @endphp
                        @foreach ($customerLinks as $item)
                            <a href="{{ $item['route'] }}"
                               class="flex items-center gap-3 rounded-2xl px-3 py-2 transition {{ $item['active'] ? 'bg-[#DB4437]/10 text-[#DB4437] font-semibold shadow-sm' : 'text-gray-600 hover:bg-[#FFF2E9]' }}">
                                <span class="h-2 w-2 rounded-full {{ $item['active'] ? 'bg-[#DB4437]' : 'bg-[#DB4437]/60' }}"></span>
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </nav>
                </aside>

                <div class="flex flex-col gap-8">
                    <div class="rounded-3xl border border-[#FFE7D6] bg-white px-6 py-8 shadow-lg sm:px-10 sm:py-12">
                        <header class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <h1 class="text-3xl font-bold text-[#DB4437]">{{ __('Properti Favorit Anda') }}</h1>
                                <p class="mt-2 text-sm text-gray-600 sm:text-base">
                                    {{ __('Simpan rumah impian Anda dan bandingkan kapan saja. Daftar ini tersinkron otomatis dengan galeri properti.') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-3 rounded-2xl bg-[#FFF2E9] px-4 py-3 text-xs font-semibold uppercase tracking-[0.3em] text-[#DB4437] shadow-sm">
                                <span>{{ __('Total') }}</span>
                                <span>{{ $favorites->count() }}</span>
                            </div>
                        </header>

                        <div data-favorites-empty class="{{ $favorites->isEmpty() ? '' : 'hidden' }} mt-10 rounded-3xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center text-sm text-gray-500">
                            {{ __('Anda belum menyimpan properti favorit. Klik ikon hati pada galeri untuk menambahkannya ke sini.') }}
                        </div>

                        <div data-favorites-grid class="mt-10 grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                            @foreach ($favorites as $property)
                                <article data-favorite-card class="flex h-full flex-col overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                                    <div class="relative h-48 overflow-hidden">
                                        @if ($property->primaryMediaUrl)
                                            <img src="{{ $property->primaryMediaUrl }}" alt="{{ $property->nama }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center bg-gray-100 text-xs text-gray-500">
                                                {{ __('Tidak ada media') }}
                                            </div>
                                        @endif
                                        <button
                                            type="button"
                                            class="js-favorite-toggle absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#DB4437] text-white shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#DB4437]"
                                            data-property-id="{{ $property->id }}"
                                            data-store-url="{{ route('pelanggan.favorites.store', $property) }}"
                                            data-destroy-url="{{ route('pelanggan.favorites.destroy', $property) }}"
                                            data-favorited="true"
                                            data-label-active="{{ __('Hapus dari favorit') }}"
                                            data-label-inactive="{{ __('Simpan ke favorit') }}"
                                            data-remove-on-unfavorite="true"
                                            aria-pressed="true"
                                            title="{{ __('Hapus dari favorit') }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex flex-1 flex-col gap-4 p-5">
                                        <div class="space-y-1">
                                            <h2 class="text-lg font-semibold text-gray-900">{{ $property->nama }}</h2>
                                            <p class="text-xs uppercase tracking-widest text-gray-400">{{ $property->lokasi }}</p>
                                        </div>
                                        <div class="rounded-2xl bg-gray-50 px-4 py-3">
                                            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Harga') }}</p>
                                            <p class="text-lg font-bold text-[#DB4437]">Rp {{ number_format($property->harga, 0, ',', '.') }}</p>
                                        </div>
                                        @if ($property->spesifikasi)
                                            <p class="line-clamp-3 text-sm leading-relaxed text-gray-600">
                                                {{ \Illuminate\Support\Str::limit($property->spesifikasi, 160) }}
                                            </p>
                                        @endif
                                        <div class="mt-auto flex items-center justify-between text-xs text-gray-500">
                                            <span class="inline-flex items-center gap-2 rounded-full bg-[#2563EB]/10 px-3 py-1 text-[11px] font-semibold text-[#2563EB]">
                                                {{ $property->tipe_properti ? ($types[$property->tipe_properti] ?? \Illuminate\Support\Str::title($property->tipe_properti)) : __('Properti') }}
                                            </span>
                                            @php
                                                $favoriteTimestamp = optional($property->pivot)->created_at ?? $property->updated_at;
                                            @endphp
                                            <span class="tracking-[0.25em] uppercase">{{ optional($favoriteTimestamp)->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pelanggan.favorit.script')
</x-app-layout>
