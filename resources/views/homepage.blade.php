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

            <!-- Enhanced Search Bar -->
            <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-xl p-3 flex flex-col sm:flex-row items-center justify-between gap-2 max-w-4xl mx-auto transform transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 border border-gray-100">
                <!-- Location -->
                <button class="group relative flex items-center gap-2 w-full sm:w-auto bg-gray-50 px-4 py-2.5 rounded-2xl text-sm font-medium text-gray-700 transition-all duration-300 hover:bg-white hover:shadow-md overflow-hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DB4437] transition-all duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a1 1 0 01-.832-.445C7.07 14.917 4 10.91 4 7a6 6 0 1112 0c0 3.91-3.07 7.917-5.168 10.555A1 1 0 0110 18zm0-13a3 3 0 100 6 3 3 0 000-6z" clip-rule="evenodd" />
                    </svg>
                    <span class="transition-transform duration-300 group-hover:translate-x-0.5">Location</span>
                </button>

                <!-- Property Type -->
                <button class="group relative flex items-center gap-2 w-full sm:w-auto bg-gray-50 px-4 py-2.5 rounded-2xl text-sm font-medium text-gray-700 transition-all duration-300 hover:bg-white hover:shadow-md overflow-hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DB4437] transition-all duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 1.293a1 1 0 00-1.414 0l-8 8a1 1 0 001.414 1.414L3 10.414V18a2 2 0 002 2h10a2 2 0 002-2v-7.586l.293.293a1 1 0 001.414-1.414l-8-8z" />
                    </svg>
                    <span class="transition-transform duration-300 group-hover:translate-x-0.5">Property Type</span>
                </button>

                <!-- Budget -->
                <button class="group relative flex items-center gap-2 w-full sm:w-auto bg-gray-50 px-4 py-2.5 rounded-2xl text-sm font-medium text-gray-700 transition-all duration-300 hover:bg-white hover:shadow-md overflow-hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DB4437] transition-all duration-300 group-hover:scale-110 group-hover:rotate-12" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                    </svg>
                    <span class="transition-transform duration-300 group-hover:translate-x-0.5">Budget</span>
                </button>

                <!-- Search Button -->
                <button 
                    id="search-overlay-open"
                    type="button"
                    data-search-overlay-open
                    class="bg-[#DB4437] text-white font-semibold px-6 py-2 rounded-full w-full sm:w-auto hover:bg-[#c63c31] transition-all duration-300 hover:scale-105 hover:shadow-xl transform hover:-translate-y-0.5"
                >
                    Search Now
                </button>
            </div>
        </div>
    </section>

    @include('components.property-search-overlay')

    <!-- Properties Section -->
    <section class="max-w-7xl mx-auto py-16 px-4 sm:px-6 md:px-10 relative">
        <!-- Decorative Background -->
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#FFF2E9]/30 rounded-full blur-[150px] -z-10"></div>
        
        <div class="mb-12 text-center md:text-left">
            <h2 class="text-2xl md:text-4xl font-bold text-gray-900 mb-2 transform transition-all duration-500 hover:translate-x-2">Some of our Properties</h2>
            <p class="text-gray-600 text-base md:text-lg flex items-center justify-center md:justify-start gap-2">
                <span class="w-2 h-2 bg-[#DB4437] rounded-full animate-pulse"></span>
                Exclusive Homes for You
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
            @foreach ([
                ['Cluster 12', 'https://images.unsplash.com/photo-1568605114967-8130f3a36994', 'Rp 750.000.000'],
                ['Cluster 13', 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c', 'Rp 790.000.000'],
                ['Cluster 14', 'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde', 'Rp 780.000.000'],
                ['Cluster 15', 'https://images.unsplash.com/photo-1599423300746-b62533397364', 'Rp 795.000.000'],
            ] as [$name, $img, $price])
                <div class="group bg-gradient-to-br from-white to-gray-50 rounded-3xl shadow-lg hover:shadow-[0_20px_60px_rgba(0,0,0,0.15)] transition-all duration-700 overflow-hidden transform hover:-translate-y-3 hover:scale-[1.02] border border-gray-100 hover:border-[#DB4437]/20">
                    <div class="relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10"></div>
                        <img src="{{ $img }}" alt="{{ $name }}" class="w-full h-48 sm:h-52 object-cover transition-all duration-700 group-hover:scale-125 group-hover:rotate-3">
                        
                        <!-- Floating Badge -->
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-xs font-semibold text-[#DB4437] shadow-lg opacity-0 group-hover:opacity-100 transform translate-x-4 group-hover:translate-x-0 transition-all duration-500 z-20">
                            View Details
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <h3 class="font-bold text-xl text-gray-900 mb-2 group-hover:text-[#DB4437] transition-colors duration-300">{{ $name }}</h3>
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        </p>

                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 mb-1">Start at</span>
                                <span class="font-bold text-base text-[#DB4437] group-hover:scale-110 inline-block transition-transform duration-300">{{ $price }}</span>
                            </div>
                            <a href="#" class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-[#DB4437] to-[#c63c31] text-white rounded-full shadow-md hover:shadow-xl transition-all duration-300 transform group-hover:scale-110 group-hover:rotate-12">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Explore Property Section -->
    <section class="relative rounded-[40px] overflow-hidden my-10 sm:my-16 mx-4 md:mx-20 group">
        <div class="relative h-72 sm:h-96">
            <img 
                src="https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=1400&q=80" 
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
            
            <button class="mt-6 bg-gradient-to-r from-[#DB4437] to-[#c63c31] text-white px-8 py-3 rounded-full font-semibold hover:shadow-[0_15px_40px_rgba(219,68,55,0.4)] transition-all duration-500 hover:scale-110 transform hover:-translate-y-1 group/btn relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/30 to-white/0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-700"></div>
                <span class="relative flex items-center justify-center gap-2">
                    Explore All Property
                    <svg class="w-5 h-5 group-hover/btn:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </span>
            </button>
        </div>
    </section>

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
                        <a 
                            href="{{ asset('assets/brochures/latest-property.pdf') }}" 
                            class="inline-flex items-center gap-3 bg-[#DB4437] text-white px-6 py-3 rounded-full font-semibold shadow-lg hover:bg-[#c63c31] transition-all duration-300"
                            download
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                            </svg>
                            Download Our Newest Flyer
                        </a>
                        <a 
                            href="{{ asset('assets/brochures/latest-property.pdf') }}" 
                            class="inline-flex items-center gap-2 text-[#DB4437] font-medium hover:text-[#c63c31] transition-all duration-300"
                            target="_blank"
                        >
                            Pratinjau secara online
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 3h7m0 0v7m0-7L10 14M5 5h3m-3 0v14h14v-3" />
                            </svg>
                        </a>
                    </div>
                    <p class="text-xs text-gray-500">
                        Simpan file terbaru kamu sebagai <code class="font-mono bg-white/70 px-2 py-1 rounded">public/assets/brochures/latest-property.pdf</code> untuk memperbarui tautan ini.
                    </p>
                </div>

                <div class="brochure-media relative px-6 sm:px-16 pb-14 mt-8">
                    <div class="brochure-slider rounded-[2.5rem] overflow-hidden shadow-[0_25px_55px_rgba(16,24,40,0.16)] ring-1 ring-[#E4E7F2]/70" data-slider>
                        <div class="brochure-slide is-active" data-slide>
                            <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1600&q=80" alt="Modern villa exterior" class="w-full h-full object-cover">
                        </div>
                        <div class="brochure-slide" data-slide>
                            <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1600&q=80" alt="Cozy living room interior" class="w-full h-full object-cover">
                        </div>
                        <div class="brochure-slide" data-slide>
                            <img src="https://images.unsplash.com/photo-1580587774054-7c9549d3df4e?auto=format&fit=crop&w=1600&q=80" alt="Luxury bedroom design" class="w-full h-full object-cover">
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
            const overlay = document.getElementById('search-overlay');
            const openButtons = document.querySelectorAll('[data-search-overlay-open], #search-overlay-open');
            const closeBtn = document.getElementById('search-overlay-close');

            if (overlay && closeBtn && openButtons.length > 0) {
                const openOverlay = () => {
                    overlay.classList.remove('hidden');
                    overlay.classList.add('flex');
                    document.body.classList.add('overflow-hidden');
                };

                const closeOverlay = () => {
                    overlay.classList.add('hidden');
                    overlay.classList.remove('flex');
                    document.body.classList.remove('overflow-hidden');
                };

                openButtons.forEach((btn) => btn.addEventListener('click', openOverlay));
                closeBtn.addEventListener('click', closeOverlay);

                overlay.addEventListener('click', (event) => {
                    if (event.target === overlay) {
                        closeOverlay();
                    }
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape' && !overlay.classList.contains('hidden')) {
                        closeOverlay();
                    }
                });
            }

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
