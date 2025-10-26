<x-app-layout>
    <section class="relative overflow-hidden bg-gradient-to-br from-[#FFF5F0] via-[#FFE7D6] to-white py-20">
        <div class="absolute inset-0">
            <div class="absolute -top-32 -right-20 h-80 w-80 rounded-full bg-[#DB4437]/20 blur-[120px]"></div>
            <div class="absolute -bottom-24 -left-10 h-96 w-96 rounded-full bg-[#FFE7D6]/60 blur-[140px]"></div>
        </div>
        <div class="relative mx-auto flex max-w-6xl flex-col items-center gap-8 px-4 text-center text-gray-900 md:flex-row md:text-left">
            <div class="flex-1 space-y-6">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/70 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-[#DB4437]">
                    {{ __('Jaya Tibar Group') }}
                </span>
                <h1 class="text-4xl font-bold leading-snug md:text-5xl">
                    {{ __('Galeri Properti & Filosofi Kami') }}
                </h1>
                <p class="text-base text-gray-600 md:text-lg">
                    {{ __('Eksplorasi portofolio hunian unggulan kami dan temukan bagaimana visi, misi, serta nilai JTG menghadirkan kehidupan modern yang lebih baik.') }}
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="#property-showcase" class="inline-flex items-center gap-2 rounded-full bg-[#DB4437] px-5 py-3 text-sm font-semibold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-[#c63c31]">
                        {{ __('Lihat Koleksi Properti') }}
                    </a>
                </div>
            </div>
            <div class="flex-1">
                <div class="relative overflow-hidden rounded-[2.5rem] border border-white/60 bg-white/80 shadow-xl backdrop-blur">
                    <div class="pointer-events-none absolute inset-0 rounded-[2.5rem] border border-white/35 shadow-[0_24px_55px_rgba(255,255,255,0.32),0_22px_48px_rgba(17,24,39,0.18)]"></div>
                    <img src="{{ asset('assets/asset gallery.jpg') }}" alt="Property Gallery" class="relative h-80 w-full rounded-[2.5rem] object-cover shadow-[0_16px_38px_rgba(255,255,255,0.4),0_20px_52px_rgba(15,23,42,0.2)]">
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto grid max-w-6xl gap-10 px-4 md:grid-cols-2">
            <article class="space-y-4 rounded-3xl border border-gray-200 bg-gray-50 px-6 py-6 shadow-sm">
                <h2 class="text-2xl font-semibold text-gray-900">{{ __('Visi Kami') }}</h2>
                <p class="text-sm leading-relaxed text-gray-600">
                    {{ __('To redefine modern living by creating innovative, sustainable, and aesthetically pleasing residential communities that enhance the quality of life for our clients and set new standards in property development.') }}
                </p>
            </article>
            <article class="space-y-4 rounded-3xl border border-gray-200 bg-gray-50 px-6 py-6 shadow-sm">
                <h2 class="text-2xl font-semibold text-gray-900">{{ __('Misi Kami') }}</h2>
                <p class="text-sm leading-relaxed text-gray-600">
                    {{ __('To develop a trusted business group in the field of property and infrastructure with the spirit of building and sustainability, thereby creating better value for people\'s lives.') }}
                </p>
            </article>
        </div>
    </section>

    <section class="bg-[#F8FAFF] py-16">
        <div class="mx-auto grid max-w-6xl gap-12 px-4 md:grid-cols-[1.25fr_1fr] md:items-center">
            <div class="space-y-6">
                <h2 class="text-3xl font-bold text-gray-900">{{ __('Tentang Jaya Tibar Group') }}</h2>
                <p class="text-sm leading-relaxed text-gray-600">
                    {{ __('Founded in late 2023, JAYA TIBAR GROUP is a collaborative property venture made up of experienced professionals in engineering, architecture, and construction. Focused on the growing Pekanbaru market, the group aims to meet the demand for affordable housing and support regional development.') }}
                </p>
                <p class="text-sm leading-relaxed text-gray-600">
                    {{ __('Targeting young families with moderate to lower incomes, JAYA TIBAR GROUP offers housing solutions that include government-subsidized options and adheres to relevant regulations. Their goal is to contribute to local growth while preparing for future expansion and public listing.') }}
                </p>
            </div>
            <div class="grid gap-4 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">{{ __('Nilai-nilai Bisnis') }}</h3>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex items-start gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-[#DB4437]"></span>
                        {{ __('Integrity: we uphold the highest ethical standards in every interaction.') }}
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-[#DB4437]"></span>
                        {{ __('Quality Excellence: superior craftsmanship and design are non-negotiable.') }}
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-[#DB4437]"></span>
                        {{ __('Innovation & Sustainability: embracing new technologies and eco-friendly practices.') }}
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-[#DB4437]"></span>
                        {{ __('Customer Focus: personalized service to deliver meaningful experiences.') }}
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-[#DB4437]"></span>
                        {{ __('Collaboration & Impact: working with partners and communities to uplift the broader region.') }}
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section id="property-showcase" class="bg-white py-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">{{ __('Koleksi Properti Terbaru') }}</h2>
                    <p class="text-sm text-gray-500">
                        {{ __('Properti yang telah diupload akan tampil secara otomatis bagi publik di halaman galeri dan beranda.') }}
                    </p>
                </div>
                <div class="flex w-full flex-col items-stretch gap-3 md:w-auto md:items-end">
                    <form method="GET" action="{{ route('gallery.index') }}" class="grid grid-cols-2 gap-2 sm:grid-cols-5 md:grid-cols-6">
                        <input
                            type="text"
                            name="q"
                            value="{{ $filters['q'] ?? '' }}"
                            placeholder="{{ __('Cari nama/lokasi/kata kunci') }}"
                            class="col-span-2 rounded-2xl border border-gray-200 bg-white px-3 py-2 text-sm focus:border-[#DB4437] focus:ring-[#DB4437] sm:col-span-2"
                        >
                        <select name="type" class="rounded-2xl border border-gray-200 bg-white px-3 py-2 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]">
                            <option value="">{{ __('Tipe (semua)') }}</option>
                            @foreach ($types as $key => $label)
                                <option value="{{ $key }}" {{ ($filters['type'] ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="price_min" value="{{ $filters['price_min'] ?? '' }}" inputmode="numeric" min="0" placeholder="{{ __('Harga min') }}" class="rounded-2xl border border-gray-200 bg-white px-3 py-2 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]">
                        <input type="number" name="price_max" value="{{ $filters['price_max'] ?? '' }}" inputmode="numeric" min="0" placeholder="{{ __('Harga max') }}" class="rounded-2xl border border-gray-200 bg-white px-3 py-2 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]">
                        <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-[#DB4437] px-4 py-2 text-sm font-semibold text-white shadow hover:bg-[#c63c31]">{{ __('Cari') }}</button>
                        @if (!empty(array_filter($filters ?? [])))
                            <a href="{{ route('gallery.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">{{ __('Reset') }}</a>
                        @endif
                    </form>
                    <span class="text-end text-xs font-semibold uppercase tracking-[0.3em] text-[#DB4437]">
                        {{ __('Menampilkan :count properti', ['count' => $properties->count()]) }}
                    </span>
                </div>
            </div>

            @if ($properties->isEmpty())
                <div class="mt-10 rounded-3xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center text-sm text-gray-500">
                    {{ __('Belum ada properti yang dipublikasikan. Admin dapat mengunggah listing dari dashboard untuk menampilkannya di sini.') }}
                </div>
            @else
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($properties as $property)
                        @php
                            $isFavorited = isset($favoritePropertyIds) && $favoritePropertyIds->contains($property->id);
                        @endphp
                        <article
                            class="group flex h-full flex-col overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg cursor-pointer js-open-property"
                            data-id="{{ $property->id }}"
                            aria-label="{{ __('Lihat detail :name', ['name' => $property->nama]) }}"
                            role="button"
                            tabindex="0"
                        >
                            <div class="relative h-52 overflow-hidden">
                                @if ($property->primaryMediaUrl)
                                    <img src="{{ $property->primaryMediaUrl }}" alt="{{ $property->nama }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gray-100 text-xs text-gray-500">
                                        {{ __('Tidak ada media') }}
                                    </div>
                                @endif
                                <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-[11px] font-semibold text-[#2563EB] shadow">
                                    {{ $property->status === 'published' ? __('Tersedia') : \Illuminate\Support\Str::upper($property->status) }}
                                </span>
                                @auth
                                    <button
                                        type="button"
                                        class="js-favorite-toggle absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full shadow transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#DB4437] {{ $isFavorited ? 'bg-[#DB4437] text-white' : 'bg-white/90 text-[#DB4437]' }}"
                                        data-property-id="{{ $property->id }}"
                                        data-store-url="{{ route('pelanggan.favorites.store', $property) }}"
                                        data-destroy-url="{{ route('pelanggan.favorites.destroy', $property) }}"
                                        data-favorited="{{ $isFavorited ? 'true' : 'false' }}"
                                        data-label-active="{{ __('Hapus dari favorit') }}"
                                        data-label-inactive="{{ __('Simpan ke favorit') }}"
                                        aria-pressed="{{ $isFavorited ? 'true' : 'false' }}"
                                        title="{{ $isFavorited ? __('Hapus dari favorit') : __('Simpan ke favorit') }}"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="{{ $isFavorited ? 'currentColor' : 'none' }}">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                        </svg>
                                    </button>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-[#DB4437] shadow transition hover:scale-105"
                                        title="{{ __('Masuk untuk menyimpan favorit') }}"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                        </svg>
                                    </a>
                                @endauth
                            </div>
                            <div class="flex flex-1 flex-col gap-4 p-5">
                                <div class="space-y-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $property->nama }}</h3>
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
                                @if ($property->deskripsi)
                                    <p class="line-clamp-3 text-xs text-gray-400">
                                        {{ \Illuminate\Support\Str::limit($property->deskripsi, 140) }}
                                    </p>
                                @endif
                                <div class="mt-auto flex items-center justify-between">
                                    <span class="inline-flex items-center gap-2 rounded-full bg-[#2563EB]/10 px-3 py-1 text-[11px] font-semibold text-[#2563EB]">
                                        {{ $types[$property->tipe_properti] ?? \Illuminate\Support\Str::title($property->tipe_properti) }}
                                    </span>
                                    <span class="text-[11px] uppercase tracking-[0.25em] text-gray-400">
                                        {{ $property->updated_at->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Property Detail Modal --}}
    @php
        $propertyPayload = $properties->map(function ($p) use ($types) {
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
                if (e.touches.length > 1) return; // ignore multi-touch
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
    @include('pelanggan.favorit.script')
</x-app-layout>
