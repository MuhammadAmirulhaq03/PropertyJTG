    <!-- Search Overlay -->
    <div 
        id="search-overlay" 
        class="fixed inset-0 z-40 hidden items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
        aria-labelledby="search-overlay-title"
    >
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300"></div>

        <div class="relative z-10 max-w-4xl w-full bg-white/95 backdrop-blur-md rounded-3xl shadow-[0_30px_80px_rgba(16,24,40,0.25)] p-6 sm:p-10 overflow-y-auto max-h-[90vh] border border-white/60">
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <h2 id="search-overlay-title" class="text-2xl sm:text-3xl font-bold text-gray-900">Find Your Next Property</h2>
                    <p class="text-gray-500 mt-1">Filter by location, type, budget, space, specifications, or keywords.</p>
                </div>
                <button 
                    id="search-overlay-close" 
                    type="button"
                    class="shrink-0 bg-[#FFE7D6] text-gray-700 hover:bg-[#FFDCC4] transition-all duration-300 rounded-full p-2 shadow-sm hover:shadow-md"
                    aria-label="Close search form"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <form action="{{ url('/properties/search') }}" method="GET" class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <label class="space-y-2">
                        <span class="text-sm font-semibold text-gray-700">Location</span>
                        <input 
                            type="text" 
                            name="location"
                            value="{{ request('location') }}"
                            placeholder="City, area, or landmark"
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-[#DB4437] focus:ring-2 focus:ring-[#DB4437]/40 transition-all duration-300 placeholder:text-gray-400"
                        >
                    </label>

                    <label class="space-y-2">
                        <span class="text-sm font-semibold text-gray-700">Property Type</span>
                        <select 
                            name="type"
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-[#DB4437] focus:ring-2 focus:ring-[#DB4437]/40 transition-all duration-300 text-gray-600"
                        >
                            <option value="">Select type</option>
                            <option value="house" @selected(request('type') === 'house')>House</option>
                            <option value="apartment" @selected(request('type') === 'apartment')>Apartment</option>
                            <option value="villa" @selected(request('type') === 'villa')>Villa</option>
                            <option value="commercial" @selected(request('type') === 'commercial')>Commercial</option>
                            <option value="land" @selected(request('type') === 'land')>Land</option>
                        </select>
                    </label>

                    <div class="space-y-2">
                        <span class="text-sm font-semibold text-gray-700 block">Price Range</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <input 
                                type="number" 
                                name="price_min"
                                min="0"
                                value="{{ request('price_min') }}"
                                placeholder="Min price"
                                class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-[#DB4437] focus:ring-2 focus:ring-[#DB4437]/40 transition-all duration-300 placeholder:text-gray-400"
                            >
                            <input 
                                type="number" 
                                name="price_max"
                                min="0"
                                value="{{ request('price_max') }}"
                                placeholder="Max price"
                                class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-[#DB4437] focus:ring-2 focus:ring-[#DB4437]/40 transition-all duration-300 placeholder:text-gray-400"
                            >
                        </div>
                    </div>

                    <div class="space-y-2">
                        <span class="text-sm font-semibold text-gray-700 block">Land / Building Size</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <input 
                                type="number" 
                                name="area_min"
                                min="0"
                                value="{{ request('area_min') }}"
                                placeholder="Min sqm"
                                class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-[#DB4437] focus:ring-2 focus:ring-[#DB4437]/40 transition-all duration-300 placeholder:text-gray-400"
                            >
                            <input 
                                type="number" 
                                name="area_max"
                                min="0"
                                value="{{ request('area_max') }}"
                                placeholder="Max sqm"
                                class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-[#DB4437] focus:ring-2 focus:ring-[#DB4437]/40 transition-all duration-300 placeholder:text-gray-400"
                            >
                        </div>
                    </div>

                    <label class="space-y-2 sm:col-span-2">
                        <span class="text-sm font-semibold text-gray-700">Specifications</span>
                        <input 
                            type="text" 
                            name="specs"
                            value="{{ request('specs') }}"
                            placeholder="Bedrooms, bathrooms, facilities, etc."
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-[#DB4437] focus:ring-2 focus:ring-[#DB4437]/40 transition-all duration-300 placeholder:text-gray-400"
                        >
                    </label>

                    <label class="space-y-2 sm:col-span-2">
                        <span class="text-sm font-semibold text-gray-700">Keywords</span>
                        <input 
                            type="text" 
                            name="keywords"
                            value="{{ request('keywords') }}"
                            placeholder="e.g. swimming pool, near MRT"
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-[#DB4437] focus:ring-2 focus:ring-[#DB4437]/40 transition-all duration-300 placeholder:text-gray-400"
                        >
                    </label>
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-3">
                    <a 
                        href="{{ url('/properties/search') }}" 
                        class="w-full sm:w-auto px-6 py-3 rounded-full border border-gray-200 text-gray-600 hover:border-[#DB4437]/40 hover:text-[#DB4437] transition-all duration-300 text-center"
                    >
                        Reset Filters
                    </a>
                    <button 
                        type="submit" 
                        class="w-full sm:w-auto px-6 py-3 rounded-full bg-[#DB4437] text-white font-semibold hover:bg-[#c63c31] transition-all duration-300 shadow-lg hover:shadow-xl"
                    >
                        Search Property
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const overlay = document.getElementById('search-overlay');
            const openButtons = document.querySelectorAll('[data-search-overlay-open]');
            const closeBtn = document.getElementById('search-overlay-close');

            if (!overlay || openButtons.length === 0 || !closeBtn) {
                return;
            }

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

            openButtons.forEach((btn) => {
                btn.addEventListener('click', openOverlay);
            });

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
        });
    </script>
