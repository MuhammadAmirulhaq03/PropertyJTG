<x-app-layout>
    <section class="relative overflow-hidden bg-gradient-to-br from-[#0F172A] via-[#1E293B] to-[#0F172A] py-20">
        <div class="absolute inset-0">
            <div class="absolute -top-32 -right-20 h-80 w-80 rounded-full bg-[#DB4437]/30 blur-[120px]"></div>
            <div class="absolute -bottom-24 -left-10 h-96 w-96 rounded-full bg-[#FFE7D6]/40 blur-[140px]"></div>
        </div>
        <div class="relative mx-auto flex max-w-6xl flex-col items-center gap-8 px-4 text-center text-white md:flex-row md:text-left">
            <div class="flex-1 space-y-6">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-[#FFE7D6]">
                    {{ __('Jaya Tibar Group') }}
                </span>
                <h1 class="text-4xl font-bold leading-snug md:text-5xl">
                    {{ __('Galeri Properti & Filosofi Kami') }}
                </h1>
                <p class="text-base text-slate-200 md:text-lg">
                    {{ __('Eksplorasi portofolio hunian unggulan kami dan temukan bagaimana visi, misi, serta nilai JTG menghadirkan kehidupan modern yang lebih baik.') }}
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="#property-showcase" class="inline-flex items-center gap-2 rounded-full bg-[#FFE7D6] px-5 py-3 text-sm font-semibold text-[#0F172A] transition hover:-translate-y-0.5">
                        {{ __('Lihat Koleksi Properti') }}
                    </a>
                </div>
            </div>
            <div class="flex-1">
                <div class="overflow-hidden rounded-3xl border border-white/20 bg-white/10 shadow-xl backdrop-blur">
                    <img src="https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=1200&q=80" alt="Property Gallery" class="h-80 w-full object-cover">
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
                <span class="text-xs font-semibold uppercase tracking-[0.3em] text-[#DB4437]">
                    {{ __('Menampilkan :count properti', ['count' => $properties->count()]) }}
                </span>
            </div>

            @if ($properties->isEmpty())
                <div class="mt-10 rounded-3xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center text-sm text-gray-500">
                    {{ __('Belum ada properti yang dipublikasikan. Admin dapat mengunggah listing dari dashboard untuk menampilkannya di sini.') }}
                </div>
            @else
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($properties as $property)
                        <article class="group flex h-full flex-col overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
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
</x-app-layout>
