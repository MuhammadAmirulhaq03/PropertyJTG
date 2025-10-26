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
                                <article
                                    data-favorite-card
                                    class="group flex h-full flex-col overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg cursor-pointer js-open-property"
                                    data-id="{{ $property->id }}"
                                    aria-label="{{ __('Lihat detail :name', ['name' => $property->nama]) }}"
                                    role="button"
                                    tabindex="0"
                                >
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

    {{-- Property Detail Modal for Favorites --}}
    @php
        $propertyPayload = $favorites->map(function ($p) use ($types) {
            return [
                'id' => $p->id,
                'nama' => $p->nama,
                'lokasi' => $p->lokasi,
                'harga' => (int) $p->harga,
                'status' => $p->status,
                'tipe_properti' => $types[$p->tipe_properti] ?? \Illuminate\Support\Str::title($p->tipe_properti),
                'spesifikasi' => $p->spesifikasi,
                'deskripsi' => $p->deskripsi,
                'updated_at' => optional($p->updated_at)->format('d M Y'),
                'media' => $p->media->map(fn ($m) => [
                    'url' => $m->url,
                    'type' => $m->media_type,
                    'caption' => $m->caption,
                ])->values(),
            ];
        })->values();
    @endphp

    <div id="property-modal" class="fixed inset-0 z-50 hidden">
        <div id="property-modal-overlay" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
        <div class="pointer-events-none absolute inset-0 flex items-center justify-center px-4 py-10">
            <div class="pointer-events-auto flex w-full max-w-5xl max-h-[90vh] flex-col overflow-hidden rounded-3xl bg-white shadow-2xl min-h-0">
                <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                    <div>
                        <h3 id="pm-title" class="text-xl font-semibold text-gray-900">—</h3>
                        <p id="pm-location" class="text-xs uppercase tracking-widest text-gray-400">—</p>
                    </div>
                    <button id="pm-close" type="button" class="inline-flex items-center justify-center rounded-full bg-gray-100 p-2 text-gray-600 hover:bg-gray-200" aria-label="{{ __('Tutup') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto min-h-0">
                    <div class="grid gap-6 p-6 md:grid-cols-[1.2fr_1fr] min-h-0">
                        <div class="space-y-4 min-h-0">
                            <div id="pm-media-wrapper" class="relative overflow-hidden rounded-2xl border border-gray-100 bg-gray-50">
                                <img id="pm-main" src="" alt="" class="h-72 w-full object-cover">
                                <div id="pm-main-fallback" class="hidden flex h-72 w-full items-center justify-center text-sm text-gray-400">{{ __('Tidak ada media') }}</div>
                                <span id="pm-status" class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-[11px] font-semibold text-[#2563EB] shadow">—</span>
                                <button id="pm-prev" type="button" class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-white/90 p-2 text-gray-600 shadow hover:bg-white" aria-label="{{ __('Foto sebelumnya') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7" /></svg>
                                </button>
                                <button id="pm-next" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-white/90 p-2 text-gray-600 shadow hover:bg-white" aria-label="{{ __('Foto selanjutnya') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" /></svg>
                                </button>
                            </div>
                            <div id="pm-thumbs" class="no-scrollbar flex gap-3 overflow-x-auto pb-2"></div>
                        </div>
                        <div class="flex flex-col gap-4 min-h-0">
                            <div class="flex items-center justify-between">
                                <span id="pm-type" class="inline-flex items-center gap-2 rounded-full bg-[#2563EB]/10 px-3 py-1 text-[11px] font-semibold text-[#2563EB]">—</span>
                                <span id="pm-updated" class="text-[11px] uppercase tracking-[0.25em] text-gray-400">—</span>
                            </div>
                            <div class="rounded-2xl bg-gray-50 px-4 py-3">
                                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Harga') }}</p>
                                <p id="pm-price" class="text-2xl font-bold text-[#DB4437]">—</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700">{{ __('Deskripsi') }}</h4>
                                <p id="pm-desc" class="mt-1 text-sm leading-relaxed text-gray-600">—</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700">{{ __('Spesifikasi') }}</h4>
                                <p id="pm-spec" class="mt-1 whitespace-pre-line text-sm leading-relaxed text-gray-600">—</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const data = @json($propertyPayload);
            const map = new Map(data.map(p => [p.id, p]));

            const modal = document.getElementById('property-modal');
            const overlay = document.getElementById('property-modal-overlay');
            const btnClose = document.getElementById('pm-close');
            const title = document.getElementById('pm-title');
            const locationEl = document.getElementById('pm-location');
            const price = document.getElementById('pm-price');
            const desc = document.getElementById('pm-desc');
            const spec = document.getElementById('pm-spec');
            const type = document.getElementById('pm-type');
            const updated = document.getElementById('pm-updated');
            const status = document.getElementById('pm-status');
            const mainImg = document.getElementById('pm-main');
            const mainFallback = document.getElementById('pm-main-fallback');
            const mediaWrapper = document.getElementById('pm-media-wrapper');
            const thumbs = document.getElementById('pm-thumbs');
            const prevBtn = document.getElementById('pm-prev');
            const nextBtn = document.getElementById('pm-next');

            const rupiah = (val) => new Intl.NumberFormat('id-ID').format(val || 0);

            let activeMedia = [];
            let currentIndex = 0;
            let thumbButtons = [];

            const openModal = () => {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            };
            const closeModal = () => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };

            btnClose.addEventListener('click', closeModal);
            overlay.addEventListener('click', closeModal);
            document.addEventListener('keydown', (e) => {
                if (modal.classList.contains('hidden')) return;
                if (e.key === 'Escape') {
                    closeModal();
                } else if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    showPrev();
                } else if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    showNext();
                }
            });

            const renderMedia = (media) => {
                thumbs.innerHTML = '';
                activeMedia = media || [];
                currentIndex = 0;
                thumbButtons = [];

                if (!activeMedia.length) {
                    mainImg.classList.add('hidden');
                    mainImg.removeAttribute('src');
                    mainFallback.classList.remove('hidden');
                    prevBtn.disabled = true;
                    nextBtn.disabled = true;
                    return;
                }
                mainFallback.classList.add('hidden');
                mainImg.classList.remove('hidden');
                prevBtn.disabled = activeMedia.length <= 1;
                nextBtn.disabled = activeMedia.length <= 1;
                const setMain = (idx) => {
                    currentIndex = idx;
                    const item = activeMedia[idx];
                    if (!item) return;
                    mainImg.src = item.url;
                    mainImg.alt = item.caption || '';
                    thumbButtons.forEach((btn, buttonIdx) => {
                        const isActive = buttonIdx === idx;
                        btn.classList.toggle('ring-2', isActive);
                        btn.classList.toggle('ring-[#DB4437]', isActive);
                        btn.setAttribute('aria-current', isActive ? 'true' : 'false');
                    });
                };

                activeMedia.forEach((m, idx) => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'group overflow-hidden rounded-xl border border-gray-200 bg-white p-1 transition focus:outline-none focus:ring-2 focus:ring-[#DB4437]';
                    btn.setAttribute('aria-label', m.caption ? `${m.caption}` : `Media ${idx + 1}`);
                    btn.setAttribute('aria-current', 'false');
                    btn.innerHTML = `<img src="${m.url}" alt="${m.caption || ''}" class="h-16 w-24 object-cover transition group-hover:opacity-90">`;
                    btn.addEventListener('click', () => {
                        setMain(idx);
                    });
                    thumbs.appendChild(btn);
                    thumbButtons.push(btn);
                });

                setMain(0);
            };

            const showPrev = () => {
                if (!activeMedia.length) return;
                const nextIndex = (currentIndex - 1 + activeMedia.length) % activeMedia.length;
                thumbButtons[nextIndex]?.click();
            };

            const showNext = () => {
                if (!activeMedia.length) return;
                const nextIndex = (currentIndex + 1) % activeMedia.length;
                thumbButtons[nextIndex]?.click();
            };

            prevBtn.addEventListener('click', showPrev);
            nextBtn.addEventListener('click', showNext);

            let touchStartX = null;
            let touchStartY = null;
            let isSwiping = false;

            const resetTouch = () => {
                touchStartX = null;
                touchStartY = null;
                isSwiping = false;
            };

            mediaWrapper.addEventListener('touchstart', (e) => {
                if (e.touches.length > 1) return;
                touchStartX = e.touches[0].clientX;
                touchStartY = e.touches[0].clientY;
                isSwiping = false;
            }, { passive: true });

            mediaWrapper.addEventListener('touchmove', (e) => {
                if (touchStartX === null || touchStartY === null) return;
                const dx = e.touches[0].clientX - touchStartX;
                const dy = e.touches[0].clientY - touchStartY;

                if (!isSwiping && Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 20) {
                    isSwiping = true;
                    e.preventDefault();
                    if (dx < 0) {
                        showNext();
                    } else {
                        showPrev();
                    }
                    resetTouch();
                }
            }, { passive: false });

            mediaWrapper.addEventListener('touchend', resetTouch);
            mediaWrapper.addEventListener('touchcancel', resetTouch);

            const fill = (prop) => {
                title.textContent = prop.nama || '—';
                locationEl.textContent = prop.lokasi || '—';
                price.textContent = 'Rp ' + rupiah(prop.harga);
                desc.textContent = prop.deskripsi || '—';
                spec.textContent = prop.spesifikasi || '—';
                type.textContent = prop.tipe_properti || '—';
                updated.textContent = prop.updated_at || '—';
                status.textContent = prop.status === 'published' ? '{{ __('Tersedia') }}' : (prop.status || '—').toUpperCase();
                renderMedia(prop.media || []);
            };

            document.querySelectorAll('.js-open-property').forEach((card) => {
                const id = parseInt(card.getAttribute('data-id'), 10);
                const show = () => {
                    const prop = map.get(id);
                    if (!prop) return;
                    fill(prop);
                    openModal();
                };
                card.addEventListener('click', show);
                card.addEventListener('keydown', (e) => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); show(); } });
            });
        });
    </script>
</x-app-layout>
