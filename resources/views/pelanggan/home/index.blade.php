<x-app-layout>

    <!-- Hero Section -->
    <section 
        class="relative bg-cover bg-center h-[85vh] sm:h-[90vh] flex items-center overflow-hidden"
        style="background-image: url('https://images.unsplash.com/photo-1560185127-6ed189bf02f4?auto=format&fit=crop&w=1920&q=80');"
    >
        <!-- Animated Background Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-black/50 to-transparent"></div>
        
        <!-- Floating Decorative Elements -->
        <div class="absolute top-10 right-10 w-96 h-96 bg-[#DB4437]/20 rounded-full blur-[100px] animate-float"></div>
        <div class="absolute bottom-20 left-10 w-[500px] h-[500px] bg-[#FFE7D6]/20 rounded-full blur-[120px] animate-float-delayed"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-white/5 rounded-full blur-[80px] animate-pulse-slow"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 md:px-10 text-center md:text-left">
            <div class="animate-slide-up">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white leading-tight mb-4 sm:mb-6 transform transition-all duration-700 hover:scale-[1.02]">
                    Find A House<br class="hidden sm:block">That Suits You
                </h1>
                <p class="text-gray-200 text-base sm:text-lg mb-6 sm:mb-10 max-w-xl">
                    Discover your dream home with flexible options and trusted consultants.
                </p>
            </div>
            <!-- Decorative search icons (no search button) -->
            <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-xl p-3 flex flex-col sm:flex-row items-center justify-between gap-2 max-w-4xl mx-auto border border-gray-100">
                <div class="group relative flex items-center gap-2 w-full sm:w-auto bg-gray-50 px-4 py-2.5 rounded-2xl text-sm font-medium text-gray-700 transition-all duration-300 hover:bg-white hover:shadow-md overflow-hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DB4437] transition-all duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a1 1 0 01-.832-.445C7.07 14.917 4 10.91 4 7a6 6 0 1112 0c0 3.91-3.07 7.917-5.168 10.555A1 1 0 0110 18zm0-13a3 3 0 100 6 3 3 0 000-6z" clip-rule="evenodd" />
                    </svg>
                    <span class="transition-transform duration-300 group-hover:translate-x-0.5">Location</span>
                </div>
                <div class="group relative flex items-center gap-2 w-full sm:w-auto bg-gray-50 px-4 py-2.5 rounded-2xl text-sm font-medium text-gray-700 transition-all duration-300 hover:bg-white hover:shadow-md overflow-hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DB4437] transition-all duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M10.707 1.293a1 1 0 00-1.414 0l-8 8a1 1 0 001.414 1.414L3 10.414V18a2 2 0 002 2h10a2 2 0 002-2v-7.586l.293.293a1 1 0 001.414-1.414l-8-8z" />
                    </svg>
                    <span class="transition-transform duration-300 group-hover:translate-x-0.5">Property Type</span>
                </div>
                <div class="group relative flex items-center gap-2 w-full sm:w-auto bg-gray-50 px-4 py-2.5 rounded-2xl text-sm font-medium text-gray-700 transition-all duration-300 hover:bg-white hover:shadow-md overflow-hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DB4437] transition-all duration-300 group-hover:scale-110 group-hover:rotate-12" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                    </svg>
                    <span class="transition-transform duration-300 group-hover:translate-x-0.5">Budget</span>
                </div>
            </div>
            
        </div>
</section>

    @if(isset($featuredProperties) && $featuredProperties->isNotEmpty())
        <section class="bg-white py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div class="max-w-2xl">
                        <span class="inline-flex items-center gap-2 rounded-full bg-[#DB4437]/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-[#DB4437]">
                            {{ __('Properti Unggulan') }}
                        </span>
                        <h2 class="mt-4 text-3xl font-bold text-[#1F2937] sm:text-4xl">
                            {{ __('Terbaru dari Jaya Tibar Group') }}
                        </h2>
                        <p class="mt-2 text-sm text-gray-500">
                            {{ __('Listing yang telah diupload admin akan tampil otomatis di beranda dan siap dijelajahi pelanggan.') }}
                        </p>
                    </div>
                    <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 rounded-full border border-[#DB4437] px-5 py-2 text-sm font-semibold text-[#DB4437] transition hover:-translate-y-0.5 hover:bg-[#DB4437]/10">
                        {{ __('Lihat Semua Properti') }}
                    </a>
                </div>

                @php
                    $statusLabels = [
                        'published' => __('Tersedia'),
                        'draft' => __('Draft'),
                        'archived' => __('Diarsipkan'),
                    ];
                @endphp

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($featuredProperties as $property)
                        <article class="group flex h-full flex-col overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                            <div class="relative h-52 overflow-hidden">
                                @if($property->primaryMediaUrl)
                                    <img src="{{ $property->primaryMediaUrl }}" alt="{{ $property->nama }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gray-100 text-xs text-gray-500">
                                        {{ __('Belum ada media') }}
                                    </div>
                                @endif
                                <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-[11px] font-semibold text-[#2563EB] shadow">
                                    {{ $statusLabels[$property->status] ?? ucfirst($property->status) }}
                                </span>
                            </div>
                            <div class="flex flex-1 flex-col gap-3 p-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $property->nama }}</h3>
                                    <p class="text-xs uppercase tracking-widest text-gray-400">{{ $property->lokasi }}</p>
                                </div>
                                <div class="rounded-2xl bg-gray-50 px-4 py-3">
                                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Harga') }}</p>
                                    <p class="text-lg font-bold text-[#DB4437]">Rp {{ number_format($property->harga, 0, ',', '.') }}</p>
                                </div>
                                @if($property->deskripsi)
                                    <p class="line-clamp-3 text-sm leading-relaxed text-gray-600">
                                        {{ \Illuminate\Support\Str::limit($property->deskripsi, 140) }}
                                    </p>
                                @endif
                                <div class="mt-auto flex items-center justify-between text-xs text-gray-400">
                                    <span class="rounded-full bg-[#2563EB]/10 px-3 py-1 font-semibold text-[#2563EB]">
                                        {{ \Illuminate\Support\Str::title($property->tipe_properti) }}
                                    </span>
                                    <span class="uppercase tracking-[0.3em]">
                                        {{ $property->updated_at->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Customer Services Section -->
    @php
        $isCustomer = auth()->check() && auth()->user()->hasRole('customer');
        $consultantUrl = $isCustomer ? route('pelanggan.consultants.create') : (auth()->check() ? route('dashboard') : route('login'));
        $contractorUrl = $isCustomer ? route('pelanggan.contractors.create') : (auth()->check() ? route('dashboard') : route('login'));
    @endphp
    <section class="py-16 bg-gradient-to-b from-[#FFF8F2] via-[#FFF5E9] to-[#FFF2E9]/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/70 px-4 py-1 text-xs font-semibold uppercase tracking-widest text-[#DB4437]">
                    <span class="h-2 w-2 rounded-full bg-[#DB4437]"></span>
                    {{ __('Layanan Pelanggan') }}
                </span>
                <h2 class="mt-4 text-3xl sm:text-4xl font-bold text-[#DB4437]">
                    {{ __('Butuh bantuan profesional?') }}
                </h2>
                <p class="mt-3 text-gray-600 text-base sm:text-lg">
                    {{ __('Konsultan dan kontraktor kami siap membantu perjalanan properti Anda dari perencanaan hingga eksekusi.') }}
                </p>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2">
                <div class="group relative flex flex-col justify-between rounded-3xl border border-[#FFE7D6] bg-white/90 p-8 shadow-lg transition hover:-translate-y-1 hover:shadow-2xl">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF2E9] px-3 py-1 text-xs font-semibold uppercase tracking-widest text-[#DB4437]">
                            {{ __('Konsultan') }}
                        </span>
                        <h3 class="mt-4 text-2xl font-bold text-[#DB4437]">{{ __('Temui Konsultan Properti') }}</h3>
                        <p class="mt-3 text-sm text-gray-600">
                            {{ __('Diskusikan kebutuhan properti, legalitas, dan perencanaan finansial dengan pakar kami.') }}
                        </p>
                    </div>
                    <a
                        href="{{ $consultantUrl }}"
                        class="mt-8 inline-flex items-center justify-center gap-2 rounded-full bg-[#DB4437] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#c63c31]"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12h12m0 0l-4-4m4 4l-4 4" />
                        </svg>
                        {{ __('Buat Jadwal Konsultasi') }}
                    </a>
                </div>

                <div class="group relative flex flex-col justify-between rounded-3xl border border-[#FFE7D6] bg-white/90 p-8 shadow-lg transition hover:-translate-y-1 hover:shadow-2xl">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF2E9] px-3 py-1 text-xs font-semibold uppercase tracking-widest text-[#DB4437]">
                            {{ __('Kontraktor') }}
                        </span>
                        <h3 class="mt-4 text-2xl font-bold text-[#DB4437]">{{ __('Pesan Tim Kontraktor') }}</h3>
                        <p class="mt-3 text-sm text-gray-600">
                            {{ __('Bantu kami memahami proyek Anda dan kami akan menyiapkan tim kontraktor terbaik.') }}
                        </p>
                    </div>
                    <a
                        href="{{ $contractorUrl }}"
                        class="mt-8 inline-flex items-center justify-center gap-2 rounded-full bg-[#DB4437] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#c63c31]"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12h12m0 0l-4-4m4 4l-4 4" />
                        </svg>
                        {{ __('Ajukan Pemesanan Kontraktor') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Search overlay removed: gallery now hosts search --}}

    <!-- Feature Overview Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-[#FFF2E9]/80 via-white to-white py-16">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-32 left-1/3 h-80 w-80 rounded-full bg-[#FFE7D6]/40 blur-[140px]"></div>
            <div class="absolute bottom-0 right-0 h-[520px] w-[520px] bg-[#FFF2E9]/30 rounded-full blur-[140px]"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10 relative">
        <div class="absolute top-0 right-0 w-[520px] h-[520px] bg-[#FFF2E9]/30 rounded-full blur-[140px] -z-10"></div>

        @php
            $facilityHighlights = [
                ['title' => 'Integrated Camera', 'description' => 'Smart surveillance keeps every corner monitored at all times.'],
                ['title' => 'Landscape Garden', 'description' => 'Curated green open space for daily recreation and family time.'],
                ['title' => 'Prayer Building', 'description' => 'Dedicated mushola on-site for spiritual activities and gatherings.'],
                ['title' => 'Security 24 Hours', 'description' => 'Professional guards and monitoring ensure round-the-clock safety.'],
            ];
        @endphp

        <div class="grid gap-12 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
            <div class="space-y-6">
                <span class="inline-flex items-center gap-2 rounded-full bg-[#FFF2E9] px-3 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-[#DB4437]">
                    Overview
                </span>
                <div class="space-y-3">
                    <h2 class="text-3xl font-bold leading-tight text-gray-900 md:text-4xl">
                        Overview Feature &amp; Facility
                    </h2>
                    <p class="text-base leading-relaxed text-gray-600 md:text-lg">
                        Where comfort meets security in a beautifully designed community. Our cluster houses are equipped with integrated security cameras, providing round-the-clock surveillance to ensure your peace of mind. Enjoy leisurely strolls in our landscaped park, a serene space perfect for relaxation and family activities.
                    </p>
                    <p class="text-base leading-relaxed text-gray-600 md:text-lg">
                        Our dedicated on-site security personnel are available 24/7, adding an extra layer of safety for all residents. Additionally, our community features a prayer building, offering a tranquil space for spiritual reflection. Experience the ideal blend of convenience, safety, and tranquility at District 1 Cluster House.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-4 pt-4">
                    <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 rounded-full bg-[#DB4437] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#c63c31]">
                        Explore Full Gallery
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="#brochure-showcase" class="inline-flex items-center gap-2 rounded-full border border-[#DB4437]/40 px-6 py-3 text-sm font-semibold text-[#DB4437] transition hover:border-[#DB4437]">
                        Download Brochures
                    </a>
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                @foreach ($facilityHighlights as $highlight)
                    <div class="group relative overflow-hidden rounded-2xl border border-[#FFE7D6] bg-white/90 p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="absolute -top-10 -right-10 h-24 w-24 rounded-full bg-[#FFE7D6]/60 blur-2xl transition group-hover:blur-3xl"></div>
                        <div class="relative flex h-12 w-12 items-center justify-center rounded-2xl bg-[#FFE7D6] text-[#DB4437] shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ $highlight['title'] }}</h3>
                        <p class="mt-2 text-sm text-gray-600">{{ $highlight['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Explore Property Section -->
    <section class="relative rounded-[40px] overflow-hidden my-10 sm:my-16 mx-4 md:mx-20 group">
        <div class="relative h-72 sm:h-96">
            <img 
                src="{{ asset('assets/house jtg1.jpg') }}" 
                alt="Modern House" 
                class="absolute inset-0 w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-110"
            >
            <!-- Gradient Overlays -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
        </div>
        
        <div class="absolute inset-x-4 sm:right-12 md:right-20 top-1/2 transform -translate-y-1/2 bg-white/95 backdrop-blur-xl p-8 rounded-[32px] shadow-2xl max-w-md mx-auto sm:mx-0 text-center sm:text-left transition-all duration-700 hover:shadow-[0_30px_90px_rgba(0,0,0,0.3)] group-hover:scale-105 border border-white/50">
            <div class="absolute -top-4 -left-4 w-20 h-20 bg-gradient-to-br from-[#DB4437] to-[#c63c31] rounded-2xl opacity-20 blur-2xl"></div>
            
            <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-4 leading-relaxed">
                When searching for the <span class="relative inline-block text-[#DB4437] hover:scale-110 transition-transform duration-300">
                    best home
                    <svg class="absolute -bottom-1 left-0 w-full" height="4" viewBox="0 0 100 4" preserveAspectRatio="none">
                        <path d="M0,2 Q25,0 50,2 T100,2" stroke="#DB4437" stroke-width="2" fill="none" />
                    </svg>
                </span> or investment opportunity, we are your ideal choice.
            </h2>
            
            
        </div>
    </section>

    @if(false)
    <!-- Why Choose Us Section -->
    <section class="bg-gradient-to-br from-[#FFF2E9] via-[#FFE7D6]/50 to-[#FFF2E9] py-20 px-4 sm:px-6 md:px-10 relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#DB4437]/10 rounded-full blur-[120px] animate-pulse-slow"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-white/50 rounded-full blur-[150px]"></div>
        
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center relative z-10">
            <!-- Image -->
            <div class="flex justify-center group perspective-1000">
                <div class="relative transform transition-all duration-700 hover:scale-105 hover:rotate-y-3">
                    <!-- Decorative Frame -->
                    <div class="absolute -inset-4 bg-gradient-to-br from-[#DB4437]/20 to-[#FFE7D6]/20 rounded-3xl blur-2xl group-hover:blur-3xl transition-all duration-700"></div>
                    
                    <img src="https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?w=500&auto=format&fit=crop&q=60" alt="Modern House" class="relative rounded-3xl shadow-2xl w-full md:w-10/12 transition-all duration-700 group-hover:shadow-[0_30px_80px_rgba(219,68,55,0.3)] border-4 border-white">
                    
                    <!-- Floating Elements -->
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-br from-[#DB4437] to-[#c63c31] rounded-2xl shadow-xl flex items-center justify-center text-white font-bold text-lg transform rotate-12 group-hover:rotate-0 group-hover:scale-110 transition-all duration-500">
                        <div class="text-center">
                            <div class="text-2xl">5+</div>
                            <div class="text-xs">Years</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Text -->
            <div class="text-center md:text-left">
                <div class="inline-block mb-8">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-2 transform transition-all duration-500 hover:scale-105">Why</h2>
                    <p class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-[#DB4437] to-[#c63c31] bg-clip-text text-transparent">Choose Us?</p>
                    <div class="h-1 w-24 bg-gradient-to-r from-[#DB4437] to-transparent rounded-full mt-2"></div>
                </div>

                <div class="space-y-5">
                    <div class="group flex items-start gap-4 transform transition-all duration-500 hover:translate-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-[#DB4437] to-[#c63c31] rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-[#DB4437] transition-colors duration-300">Strategic Location</h4>
                            <p class="text-sm text-gray-600">Prime areas with easy access</p>
                        </div>
                    </div>

                    <div class="group flex items-start gap-4 transform transition-all duration-500 hover:translate-x-4" style="transition-delay: 50ms;">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-[#DB4437] to-[#c63c31] rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-[#DB4437] transition-colors duration-300">Strong Investment Growth</h4>
                            <p class="text-sm text-gray-600">High ROI potential</p>
                        </div>
                    </div>

                    <div class="group flex items-start gap-4 transform transition-all duration-500 hover:translate-x-4" style="transition-delay: 100ms;">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-[#DB4437] to-[#c63c31] rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-[#DB4437] transition-colors duration-300">Elegant Design</h4>
                            <p class="text-sm text-gray-600">Modern architecture</p>
                        </div>
                    </div>

                    <div class="group flex items-start gap-4 transform transition-all duration-500 hover:translate-x-4" style="transition-delay: 150ms;">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-[#DB4437] to-[#c63c31] rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-[#DB4437] transition-colors duration-300">Trusted Transactions</h4>
                            <p class="text-sm text-gray-600">Secure and transparent</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    @include('pelanggan.home.partials.about-slider')
    <!-- Brochure Section -->
    <section id="brochure-showcase" class="relative py-20 bg-gradient-to-b from-[#FFF2E9] via-[#FFF7F1] to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10">
            <div class="brochure-card relative overflow-hidden rounded-[2.5rem] border border-transparent bg-white/60 shadow-[0_28px_60px_rgba(15,23,42,0.08)] backdrop-blur">
                <div class="brochure-content px-16 sm:px-24 pt-16 pb-12 space-y-8">
                    <div class="space-y-5">
                        <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.32em] text-[#DB4437]/70">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13l4 4L17 7" />
                            </svg>
                            Brochure Update
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-bold text-[#DB4437] leading-tight">
                            Check Our Newest Property Showcase
                        </h2>
                        <p class="text-gray-600 leading-relaxed text-base md:text-lg">
                            Jelajahi katalog properti terbaru kami yang dikurasi langsung dari listing eksklusif Jaya Tibar Group. Temukan desain, fasilitas, dan promo pembiayaan terbaik untuk investasi atau hunian idamanmu.
                        </p>
                    </div>
                    <div class="grid gap-3 text-sm text-gray-600">
                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#FFE7D6] text-[#DB4437] font-semibold text-xs mt-0.5">1</span>
                            <span>Highlight unit premium lengkap dengan spesifikasi utama.</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#FFE7D6] text-[#DB4437] font-semibold text-xs mt-0.5">2</span>
                            <span>Tips pembiayaan, simulasi cicilan, dan insight investasi terkini.</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex flex-wrap items-center gap-3">
                            <a 
                                href="{{ asset('assets/brochures/Brosur regency District 1 Type 36_compressed.pdf') }}" 
                                class="inline-flex items-center gap-3 bg-[#DB4437] text-white px-6 py-3 rounded-full font-semibold shadow-lg hover:bg-[#c63c31] transition-all duration-300"
                                download
                                target="_blank" rel="noopener"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                </svg>
                                {{ __('Download Type 36 (PDF)') }}
                            </a>
                            <a 
                                href="{{ asset('assets/brochures/Brosur regency district 1 Type 38_compressed.pdf') }}" 
                                class="inline-flex items-center gap-3 bg-white text-[#DB4437] px-6 py-3 rounded-full font-semibold shadow-lg ring-1 ring-[#DB4437]/30 hover:bg-[#FFF2E9] transition-all duration-300"
                                download
                                target="_blank" rel="noopener"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                </svg>
                                {{ __('Download Type 38 (PDF)') }}
                            </a>
                        </div>
                    </div>
                    
                </div>

                <div class="brochure-media relative px-6 sm:px-16 pb-14 mt-8">
                    <div class="brochure-slider rounded-[2.5rem] overflow-hidden shadow-[0_25px_55px_rgba(16,24,40,0.16)] ring-1 ring-[#E4E7F2]/70" data-slider>
                        <div class="brochure-slide is-active" data-slide>
                            <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1600&q=80" alt="Modern villa exterior" class="w-full h-full object-cover">
                        </div>
                        <div class="brochure-slide" data-slide>
                              <img src="{{ asset('assets/asset jtg1.jpg') }}" alt="Cozy living room interior" class="w-full h-full object-cover">
                        </div>
                        <div class="brochure-slide" data-slide>
                            <img src="{{ asset('assets/asset jtg 2.jpg') }}" alt="Luxury bedroom design" class="w-full h-full object-cover">
                        </div>

                        <div class="brochure-slider-overlay pointer-events-none"></div>

                        <div class="brochure-slider-controls">
                            <button type="button" class="brochure-nav-button" data-slider-prev aria-label="Slide sebelumnya">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <div class="brochure-dots" role="tablist" aria-label="Brochure images">
                                <button type="button" class="brochure-dot is-active" data-slider-dot="0" aria-label="Slide 1"></button>
                                <button type="button" class="brochure-dot" data-slider-dot="1" aria-label="Slide 2"></button>
                                <button type="button" class="brochure-dot" data-slider-dot="2" aria-label="Slide 3"></button>
                            </div>
                            <button type="button" class="brochure-nav-button" data-slider-next aria-label="Slide selanjutnya">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="bg-white py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-flex items-center gap-2 rounded-full bg-[#DB4437]/10 px-4 py-1 text-xs font-semibold uppercase tracking-widest text-[#DB4437]">
                    <span class="h-2 w-2 rounded-full bg-[#DB4437]"></span>
                    {{ __('Pertanyaan Umum') }}
                </span>
                <h2 class="mt-4 text-3xl sm:text-4xl font-bold text-[#DB4437]">
                    {{ __('FAQ Seputar Jaya Tibar Group') }}
                </h2>
                <p class="mt-2 text-gray-600 max-w-3xl mx-auto">
                    {{ __('Temukan jawaban atas pertanyaan yang paling sering diajukan pelanggan mengenai layanan, proses pembelian, dan dukungan kami.') }}
                </p>
            </div>

            <div class="grid gap-4">
                @php
                    $faqs = [
                        [
                            'question' => __('Bagaimana proses memesan properti di Jaya Tibar Group?'),
                            'answer' => __('Pilih properti yang diminati, ajukan jadwal kunjungan, dan tim kami akan membantu proses negosiasi, dokumen, hingga serah terima.'),
                        ],
                        [
                            'question' => __('Apakah ada bantuan pembiayaan KPR?'),
                            'answer' => __('Gunakan Kalkulator KPR untuk simulasi awal dan konsultasikan dengan konsultan kami untuk rekomendasi bank atau skema KPR yang sesuai.'),
                        ],
                        [
                            'question' => __('Bagaimana cara mengunggah dokumen persyaratan?'),
                            'answer' => __('Masuk sebagai pelanggan, buka Pelanggan Center &gt; Document, lalu unggah dokumen dalam format PDF atau JPG sesuai jenis persyaratan.'),
                        ],
                        [
                            'question' => __('Apakah saya bisa memesan jasa kontraktor melalui platform ini?'),
                            'answer' => __('Ya, ajukan permintaan di menu Pemesanan Kontraktor. Tim kami akan mencocokkan kebutuhan proyek Anda dengan mitra kontraktor terpercaya.'),
                        ],
                    ];
                @endphp

                @foreach ($faqs as $faq)
                    <details class="group rounded-2xl border border-[#FFE7D6] bg-white px-6 py-5 shadow-sm transition hover:border-[#DB4437]/50">
                        <summary class="flex cursor-pointer items-center justify-between text-left text-base font-semibold text-[#DB4437]">
                            <span>{{ $faq['question'] }}</span>
                            <span class="ml-4 flex h-8 w-8 items-center justify-center rounded-full bg-[#DB4437]/10 text-[#DB4437] transition group-open:rotate-45">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m6-6H6" />
                                </svg>
                            </span>
                        </summary>
                        <div class="mt-3 text-sm leading-relaxed text-gray-600">
                            {{ $faq['answer'] }}
                        </div>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(5deg); }
            66% { transform: translate(-20px, 20px) rotate(-5deg); }
        }
        
        @keyframes float-delayed {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(-30px, 30px) rotate(-5deg); }
            66% { transform: translate(20px, -20px) rotate(5deg); }
        }
        
        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        
        .animate-float {
            animation: float 20s ease-in-out infinite;
        }
        
        .animate-float-delayed {
            animation: float-delayed 25s ease-in-out infinite;
        }
        
        .animate-slide-up {
            animation: slide-up 1s ease-out;
        }
        
        .animate-pulse-slow {
            animation: pulse-slow 4s ease-in-out infinite;
        }
        
        .perspective-1000 {
            perspective: 1000px;
        }
        
        .hover\:rotate-y-3:hover {
            transform: rotateY(3deg);
        }

        #brochure-showcase .brochure-content,
        #brochure-showcase .brochure-media {
            opacity: 0;
            transform: translateY(32px);
            transition: transform 0.8s ease, opacity 0.8s ease;
        }

        #brochure-showcase .brochure-content {
            transition-delay: 0.15s;
        }

        #brochure-showcase.is-visible .brochure-content,
        #brochure-showcase.is-visible .brochure-media {
            opacity: 1;
            transform: translateY(0);
        }

        .brochure-slider {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: 320px;
        }

        .brochure-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.7s ease, transform 0.7s ease;
            transform: scale(1.02);
        }

        .brochure-slide.is-active {
            opacity: 1;
            transform: scale(1);
            pointer-events: auto;
        }

        .brochure-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .brochure-slider-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.05) 45%, rgba(0,0,0,0) 100%);
        }

        .brochure-slider-controls {
            position: absolute;
            bottom: 1.9rem;
            left: 50%;
            transform: translateX(-50%);
            display: grid;
            grid-template-columns: auto auto auto;
            align-items: center;
            gap: 1.25rem;
            z-index: 5;
        }

        .brochure-nav-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.95);
            color: #DB4437;
            border: 1px solid rgba(255, 231, 214, 0.85);
            box-shadow: 0 12px 26px rgba(219, 68, 55, 0.18);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .brochure-nav-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 32px rgba(219, 68, 55, 0.25);
        }

        .brochure-dots {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            align-items: center;
        }

        .brochure-dot {
            width: 9px;
            height: 9px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.6);
            border: none;
            transition: background 0.25s ease, transform 0.25s ease;
        }

        .brochure-dot.is-active {
            background: #DB4437;
            transform: scale(1.2);
        }

        @media (max-width: 640px) {
            .brochure-slider {
                min-height: 240px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Search overlay removed; search moved to Gallery

            const brochureSection = document.getElementById('brochure-showcase');
            if (!brochureSection) {
                return;
            }

            const slider = brochureSection.querySelector('[data-slider]');
            const slides = slider ? Array.from(slider.querySelectorAll('[data-slide]')) : [];
            const dots = slider ? Array.from(slider.querySelectorAll('[data-slider-dot]')) : [];
            const prevBtn = slider ? slider.querySelector('[data-slider-prev]') : null;
            const nextBtn = slider ? slider.querySelector('[data-slider-next]') : null;
            let currentIndex = 0;
            let autoRotate;

            const showSlide = (index) => {
                if (slides.length === 0) {
                    return;
                }
                currentIndex = (index + slides.length) % slides.length;
                slides.forEach((slide, idx) => {
                    slide.classList.toggle('is-active', idx === currentIndex);
                });
                dots.forEach((dot, idx) => {
                    dot.classList.toggle('is-active', idx === currentIndex);
                });
            };

            const scheduleAutoRotate = () => {
                if (slides.length === 0) {
                    return;
                }
                clearInterval(autoRotate);
                autoRotate = setInterval(() => {
                    showSlide(currentIndex + 1);
                }, 5500);
            };

            prevBtn?.addEventListener('click', () => {
                showSlide(currentIndex - 1);
                scheduleAutoRotate();
            });

            nextBtn?.addEventListener('click', () => {
                showSlide(currentIndex + 1);
                scheduleAutoRotate();
            });

            dots.forEach((dot) => {
                dot.addEventListener('click', () => {
                    const target = Number(dot.getAttribute('data-slider-dot'));
                    if (!Number.isNaN(target)) {
                        showSlide(target);
                        scheduleAutoRotate();
                    }
                });
            });

            slider?.addEventListener('mouseenter', () => clearInterval(autoRotate));
            slider?.addEventListener('mouseleave', scheduleAutoRotate);

            const activate = () => {
                brochureSection.classList.add('is-visible');
                showSlide(0);
                scheduleAutoRotate();
            };

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            activate();
                            observer.disconnect();
                        }
                    });
                }, { threshold: 0.3 });

                observer.observe(brochureSection);
            } else {
                activate();
            }
        });
    </script>

</x-app-layout>
