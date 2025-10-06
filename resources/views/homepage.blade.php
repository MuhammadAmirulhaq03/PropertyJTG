<x-app-layout>
    <!-- Hero Section -->
    <section 
        class="relative bg-cover bg-center h-[90vh] flex items-center" 
        style="background-image: url('https://images.unsplash.com/photo-1560185127-6ed189bf02f4?auto=format&fit=crop&w=1920&q=80');"
    >
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-6 text-left">
            <h1 class="text-5xl md:text-6xl font-bold text-white leading-tight mb-6">
                Find A House<br>That Suits You
            </h1>
            <p class="text-gray-200 text-lg mb-10">
                Discover your dream home with flexible options and trusted consultants.
            </p>

            <!-- Search Bar -->
            <div class="bg-white rounded-2xl shadow-lg p-4 grid grid-cols-1 md:grid-cols-5 gap-4 max-w-5xl">
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Location</label>
                </div>

                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Property Type</label>
                </div>

                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Budget</label>
                </div>

                <div class="col-span-2 flex items-end">
                    <button class="w-full bg-[#DB4437] text-white font-semibold px-6 py-3 rounded-lg hover:bg-[#c63c31] transition">
                        Search Now
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="max-w-7xl mx-auto py-16 px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-xl font-semibold mb-2">Consultation</h2>
            <p class="text-gray-600 text-sm">Get expert advice from trusted property consultants.</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-xl font-semibold mb-2">Buy Property</h2>
            <p class="text-gray-600 text-sm">Choose from various homes and real estate offers.</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-xl font-semibold mb-2">Contractor</h2>
            <p class="text-gray-600 text-sm">Build your dream home with reliable services.</p>
        </div>
    </section>
</x-app-layout>
