<x-app-layout>
    <section class="relative overflow-hidden bg-gradient-to-br from-[#FFF5F0] via-[#FFE7D6]/70 to-white py-20">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-32 -right-20 h-80 w-80 rounded-full bg-[#DB4437]/20 blur-[140px]"></div>
            <div class="absolute -bottom-24 -left-10 h-96 w-96 rounded-full bg-[#FFE7D6]/50 blur-[160px]"></div>
        </div>
        <div class="relative mx-auto flex max-w-7xl flex-col gap-10 px-4 text-gray-900 md:flex-row md:items-center">
            <div class="flex-1 space-y-6">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/80 px-4 py-1 text-[11px] font-semibold uppercase tracking-[0.35em] text-[#DB4437]">
                    House View
                </span>
                <h1 class="text-4xl font-bold leading-snug md:text-5xl">
                    District 1 Cluster<br class="hidden sm:inline"> Home Overview
                </h1>
                <p class="text-base text-gray-600 md:text-lg">
                    Kenali rancangan rumah District 1 secara lengkap—mulai dari spesifikasi teknis, tata letak ruang, hingga akses menuju fasilitas di sekitar kawasan.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ asset('assets/brochures/Brosur regency District 1 Type 36_compressed.pdf') }}" class="inline-flex items-center gap-2 rounded-full bg-[#DB4437] px-5 py-3 text-sm font-semibold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-[#c63c31]" download target="_blank" rel="noopener">
                        Download Type 36
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                        </svg>
                    </a>
                    <a href="{{ asset('assets/brochures/Brosur regency district 1 Type 38_compressed.pdf') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-semibold text-[#DB4437] shadow ring-1 ring-[#DB4437]/30 transition hover:bg-[#FFF2E9]" download target="_blank" rel="noopener">
                        Download Type 38
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                        </svg>
                    </a>
                    <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 rounded-full border border-[#DB4437]/50 px-5 py-3 text-sm font-semibold text-[#DB4437] transition hover:border-[#DB4437]">
                        Lihat Koleksi Properti
                    </a>
                </div>
            </div>
            <div class="flex-1">
                <div class="rounded-[2.5rem] bg-white/80 p-8 shadow-[0_28px_55px_rgba(15,23,42,0.12)] backdrop-blur">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.3em] text-[#DB4437]/80">Quick Facts</h2>
                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        @foreach ($quickFacts as $fact)
                            <div class="rounded-2xl border border-[#FFE7D6] bg-white/80 p-4 shadow-sm">
                                <div class="text-xs font-semibold uppercase tracking-[0.25em] text-[#DB4437]/70">{{ $fact['label'] }}</div>
                                <div class="mt-2 text-base font-medium text-gray-900">{{ $fact['value'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4">
            <div class="mb-10 space-y-3 text-center md:text-left">
                <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF2E9] px-3 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-[#DB4437]">
                    Tech Specification
                </span>
                <h2 class="text-3xl font-bold text-gray-900 md:text-4xl">Spesifikasi Teknis District 1</h2>
                <p class="text-sm text-gray-600 md:text-base">
                    Material dan komponen bangunan yang memastikan kenyamanan dan keawetan hunian Anda.
                </p>
            </div>

            <div class="overflow-hidden rounded-3xl border border-[#FFE7D6] bg-white shadow-[0_28px_55px_rgba(15,23,42,0.08)]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#FFE7D6]/70 text-left text-sm text-gray-600">
                        <thead class="bg-[#FFF5EB] text-xs uppercase tracking-[0.3em] text-[#DB4437]">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">Feature</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-gray-800">District 1</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-gray-400">District 2</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FFE7D6]/50 bg-white">
                            @foreach ($technicalSpecifications as $spec)
                                <tr class="hover:bg-[#FFF8F2] transition">
                                    <td class="px-6 py-4 font-semibold text-[#DB4437]">{{ $spec['feature'] }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $spec['district1'] }}</td>
                                    <td class="px-6 py-4 text-gray-400 italic">{{ $spec['district2'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#F9FBFF] py-16">
        <div class="mx-auto max-w-7xl px-4">
            <div class="mb-10 text-center md:text-left">
                <span class="inline-flex items-center gap-2 rounded-full bg-[#2563EB]/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-[#2563EB]">
                    Design Highlights
                </span>
                <h2 class="mt-4 text-3xl font-bold text-gray-900 md:text-4xl">Konsep Tata Ruang & Visual</h2>
                <p class="mt-2 text-sm text-gray-600 md:text-base">
                    Visualisasi desain rumah yang menonjolkan efisiensi ruang, pencahayaan alami, dan hubungan indoor-outdoor.
                </p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($designImages as $image)
                    <div class="group flex h-full flex-col overflow-hidden rounded-[2rem] border border-gray-200 bg-white shadow-[0_18px_45px_rgba(15,23,42,0.08)] transition hover:-translate-y-1 hover:shadow-[0_24px_60px_rgba(15,23,42,0.14)]">
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ asset($image['path']) }}" alt="{{ $image['title'] }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                        </div>
                        <div class="flex flex-1 flex-col gap-3 p-6">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $image['title'] }}</h3>
                            <p class="text-sm text-gray-600">{{ $image['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4">
            <div class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-start">
                <div class="space-y-6">
                    <span class="inline-flex items-center gap-2 rounded-full bg-[#DB4437]/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-[#DB4437]">
                        Location & Access
                    </span>
                    <h2 class="text-3xl font-bold text-gray-900 md:text-4xl">Akses Strategis & Fasilitas Sekitar</h2>
                    <p class="text-sm text-gray-600 md:text-base">
                        Posisi District 1 memudahkan penghuni menjangkau pusat perbelanjaan, pendidikan, dan transportasi utama di Pekanbaru.
                    </p>
                    <div class="overflow-hidden rounded-[2.5rem] border border-[#FFE7D6] bg-white shadow-[0_28px_55px_rgba(15,23,42,0.12)]">
                        <img src="{{ asset($mapImage) }}" alt="Peta lokasi District 1" class="h-full w-full object-cover">
                    </div>
                </div>
                <div class="space-y-5">
                    @foreach ($amenities as $amenity)
                        <div class="group relative overflow-hidden rounded-3xl border border-[#FFE7D6] bg-[#FFF8F4] p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-[0_24px_55px_rgba(219,68,55,0.18)]">
                            <div class="text-xs font-semibold uppercase tracking-[0.35em] text-[#DB4437]/80">{{ $amenity['tag'] }}</div>
                            <h3 class="mt-3 text-xl font-semibold text-gray-900">{{ $amenity['name'] }}</h3>
                            <p class="mt-2 text-sm text-gray-600">{{ $amenity['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden py-16">
        <div class="absolute inset-0 bg-gradient-to-br from-[#FFF2E9] via-white to-[#FFF8F4]"></div>
        <div class="relative mx-auto max-w-4xl rounded-[2.5rem] border border-[#FFE7D6] bg-white/80 p-10 text-center shadow-[0_30px_70px_rgba(15,23,42,0.15)] backdrop-blur">
            <h2 class="text-3xl font-bold text-gray-900 md:text-4xl">Siap Menjelajah Lebih Jauh?</h2>
            <p class="mt-3 text-base text-gray-600 md:text-lg">
                Hubungi kami untuk jadwal kunjungan atau dapatkan brokurs terbaru District 1 dalam format digital.
            </p>
            <div class="mt-6 flex flex-wrap justify-center gap-4">
                <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 rounded-full bg-[#DB4437] px-6 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-[#c63c31]">
                    Lihat Listing Terbaru
                </a>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ asset('assets/brochures/Brosur regency District 1 Type 36_compressed.pdf') }}" class="inline-flex items-center gap-2 rounded-full border border-[#DB4437]/40 px-6 py-3 text-sm font-semibold text-[#DB4437] transition hover:border-[#DB4437]" download target="_blank" rel="noopener">
                        Unduh Brosur Type 36
                    </a>
                    <a href="{{ asset('assets/brochures/Brosur regency district 1 Type 38_compressed.pdf') }}" class="inline-flex items-center gap-2 rounded-full border border-[#DB4437]/40 px-6 py-3 text-sm font-semibold text-[#DB4437] transition hover:border-[#DB4437]" download target="_blank" rel="noopener">
                        Unduh Brosur Type 38
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
