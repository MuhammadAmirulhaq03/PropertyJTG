<x-app-layout>

    <!-- Hero Section -->
    <section 
        class="relative bg-cover bg-center h-[85vh] sm:h-[90vh] flex items-center overflow-hidden"
        style="background-image: url('https://images.unsplash.com/photo-1560185127-6ed189bf02f4?auto=format&fit=crop&w=1920&q=80');"
    >
        <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/50 to-black/40"></div>
        
        <!-- Decorative Elements -->
        <div class="absolute top-20 right-20 w-72 h-72 bg-[#DB4437]/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 left-20 w-96 h-96 bg-[#FFE7D6]/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 md:px-10 text-center md:text-left">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white leading-tight mb-4 sm:mb-6 transform transition-all duration-700 hover:scale-105">
                Find A House<br class="hidden sm:block">That Suits You
            </h1>
            <p class="text-gray-200 text-base sm:text-lg mb-6 sm:mb-10 animate-fade-in">
                Discover your dream home with flexible options and trusted consultants.
            </p>

            <!-- Search Bar -->
            <div class="bg-[#FFF2E9] rounded-3xl shadow-2xl p-4 flex flex-col sm:flex-row items-center justify-between gap-3 max-w-5xl mx-auto transform transition-all duration-500 hover:shadow-[0_20px_60px_rgba(219,68,55,0.2)] hover:-translate-y-1">
                <!-- Location -->
                <button class="group flex items-center justify-center gap-2 w-full sm:w-auto bg-[#FFE7D6] px-5 py-2 rounded-full font-medium text-gray-800 hover:bg-[#FFDCC4] transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <span class="group-hover:translate-x-1 transition-transform duration-300">Location</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700 group-hover:scale-110 group-hover:text-[#DB4437] transition-all duration-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a1 1 0 01-.832-.445C7.07 14.917 4 10.91 4 7a6 6 0 1112 0c0 3.91-3.07 7.917-5.168 10.555A1 1 0 0110 18zm0-13a3 3 0 100 6 3 3 0 000-6z" clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Property Type -->
                <button class="group flex items-center justify-center gap-2 w-full sm:w-auto bg-[#FFE7D6] px-5 py-2 rounded-full font-medium text-gray-800 hover:bg-[#FFDCC4] transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <span class="group-hover:translate-x-1 transition-transform duration-300">Property Type</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700 group-hover:scale-110 group-hover:text-[#DB4437] transition-all duration-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 1.293a1 1 0 00-1.414 0l-8 8a1 1 0 001.414 1.414L3 10.414V18a2 2 0 002 2h10a2 2 0 002-2v-7.586l.293.293a1 1 0 001.414-1.414l-8-8z" />
                    </svg>
                </button>

                <!-- Budget -->
                <button class="group flex items-center justify-center gap-2 w-full sm:w-auto bg-[#FFE7D6] px-5 py-2 rounded-full font-medium text-gray-800 hover:bg-[#FFDCC4] transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <span class="group-hover:translate-x-1 transition-transform duration-300">Budget</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700 group-hover:scale-110 group-hover:text-[#DB4437] transition-all duration-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-12.75a.75.75 0 00-1.5 0v.551a3.001 3.001 0 00-2.25 2.899.75.75 0 001.5 0 1.5 1.5 0 013 0c0 .655-.492 1.162-1.125 1.373v.877a.75.75 0 001.5 0v-.551a3.001 3.001 0 002.25-2.899.75.75 0 00-1.5 0 1.5 1.5 0 01-3 0c0-.655.492-1.162 1.125-1.373v-.877z" clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Search Button -->
                <button class="bg-[#DB4437] text-white font-semibold px-6 py-2 rounded-full w-full sm:w-auto hover:bg-[#c63c31] transition-all duration-300 hover:scale-105 hover:shadow-xl transform hover:-translate-y-0.5">
                    Search Now
                </button>
            </div>
        </div>
    </section>

    <!-- Properties Section -->
    <section class="max-w-7xl mx-auto py-16 px-4 sm:px-6 md:px-10">
        <div class="mb-10 text-center md:text-left">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 transform transition-all duration-500 hover:translate-x-2">Some of our Properties</h2>
            <p class="text-gray-600 text-base md:text-lg">Exclusive Homes for You</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
            @foreach ([
                ['Cluster 12', 'https://images.unsplash.com/photo-1568605114967-8130f3a36994', 'Rp 750.000.000'],
                ['Cluster 13', 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c', 'Rp 790.000.000'],
                ['Cluster 14', 'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde', 'Rp 780.000.000'],
                ['Cluster 15', 'https://images.unsplash.com/photo-1599423300746-b62533397364', 'Rp 795.000.000'],
            ] as [$name, $img, $price])
                <div class="group bg-white rounded-2xl shadow hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2 hover:scale-105">
                    <div class="relative overflow-hidden">
                        <img src="{{ $img }}" alt="{{ $name }}" class="w-full h-48 sm:h-52 object-cover transition-transform duration-700 group-hover:scale-110 group-hover:rotate-2">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg text-gray-800 mb-1 group-hover:text-[#DB4437] transition-colors duration-300">{{ $name }}</h3>
                        <p class="text-sm text-gray-600 mb-3">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        </p>

                        <div class="flex items-center justify-between">
                            <p class="font-semibold text-sm text-gray-800">
                                Start at <span class="text-[#DB4437] group-hover:scale-110 inline-block transition-transform duration-300">{{ $price }}</span>
                            </p>
                            <a href="#" class="text-[#DB4437] hover:text-[#c63c31] transition-all duration-300 transform group-hover:translate-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="bg-[#FFF2E9] py-20 px-4 sm:px-6 md:px-10 relative overflow-hidden">
        <!-- Decorative Background -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#DB4437]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#FFE7D6]/30 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center relative z-10">
            <!-- Image -->
            <div class="flex justify-center group">
                <div class="relative">
                    <img src="https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?w=500&auto=format&fit=crop&q=60" alt="Modern House" class="rounded-2xl shadow-lg w-full md:w-10/12 transition-all duration-700 group-hover:shadow-2xl group-hover:scale-105 group-hover:-rotate-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#DB4437]/0 to-[#DB4437]/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
            </div>

            <!-- Text -->
            <div class="text-center md:text-left">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 transform transition-all duration-500 hover:translate-x-2">Why</h2>
                <p class="text-2xl md:text-3xl text-gray-700 mb-8 transform transition-all duration-500 hover:translate-x-2">Choose Us?</p>

                <ul class="space-y-3 text-gray-800 text-base md:text-lg">
                    <li class="flex items-center gap-3 group transform transition-all duration-300 hover:translate-x-4">
                        <span class="text-[#DB4437] group-hover:scale-125 transition-transform duration-300">•</span>
                        <span class="group-hover:text-[#DB4437] transition-colors duration-300">Strategic Location</span>
                    </li>
                    <li class="flex items-center gap-3 group transform transition-all duration-300 hover:translate-x-4" style="transition-delay: 50ms;">
                        <span class="text-[#DB4437] group-hover:scale-125 transition-transform duration-300">•</span>
                        <span class="group-hover:text-[#DB4437] transition-colors duration-300">Strong Investment Growth</span>
                    </li>
                    <li class="flex items-center gap-3 group transform transition-all duration-300 hover:translate-x-4" style="transition-delay: 100ms;">
                        <span class="text-[#DB4437] group-hover:scale-125 transition-transform duration-300">•</span>
                        <span class="group-hover:text-[#DB4437] transition-colors duration-300">Elegant Design</span>
                    </li>
                    <li class="flex items-center gap-3 group transform transition-all duration-300 hover:translate-x-4" style="transition-delay: 150ms;">
                        <span class="text-[#DB4437] group-hover:scale-125 transition-transform duration-300">•</span>
                        <span class="group-hover:text-[#DB4437] transition-colors duration-300">Trusted Transactions</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Explore Property Section -->
    <section class="relative rounded-3xl overflow-hidden my-10 sm:my-16 mx-4 md:mx-20 group">
        <img 
            src="https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=1400&q=80" 
            alt="Modern House" 
            class="w-full h-72 sm:h-96 object-cover rounded-3xl transition-transform duration-700 group-hover:scale-110"
        >
        <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-transparent rounded-3xl"></div>
        <div class="absolute inset-x-4 sm:right-10 md:right-16 top-1/2 transform -translate-y-1/2 bg-white/95 backdrop-blur-sm p-6 rounded-xl shadow-lg max-w-md mx-auto sm:mx-0 text-center sm:text-left transition-all duration-500 hover:shadow-2xl hover:bg-white group-hover:scale-105">
            <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-3">
                When searching for the <span class="text-[#DB4437] inline-block transition-transform duration-300 hover:scale-110">best home</span> or investment opportunity,
                we are your ideal choice.
            </h2>
            <button class="mt-4 bg-[#DB4437] text-white px-6 py-2 rounded-full font-medium hover:bg-[#c63c30] transition-all duration-300 hover:scale-110 hover:shadow-xl transform hover:-translate-y-1">
                Explore All Property
            </button>
        </div>
    </section>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 1s ease-out;
        }
    </style>

</x-app-layout>