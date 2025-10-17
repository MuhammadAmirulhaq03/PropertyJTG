<x-app-layout>
    @php
        $formatPrice = fn (int $value) => 'Rp ' . number_format($value, 0, ',', '.');
    @endphp

    <!-- Hero -->
    <section class="relative overflow-hidden bg-gradient-to-br from-[#FFE7D6] via-white to-[#FFF5EE] py-16 sm:py-20">
        <div class="absolute inset-y-0 right-0 w-1/2 bg-[url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=1500&q=80')] bg-cover bg-center opacity-10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10 relative">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-2 bg-[#DB4437]/10 text-[#DB4437] px-4 py-1.5 rounded-full text-sm font-medium mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M12.9 14.32a8 8 0 111.414-1.414l4.386 4.386a1 1 0 01-1.414 1.414l-4.386-4.386zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" />
                    </svg>
                    Property Search
                </span>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight">
                    {{ $total }} {{ \Illuminate\Support\Str::plural('property', $total) }} match your criteria
                </h1>
                <p class="mt-4 text-gray-600 text-base sm:text-lg">
                    Explore curated listings based on your filters. Adjust the search anytime to discover properties that fit new requirements.
                </p>
                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <button 
                        type="button"
                        data-search-overlay-open
                        class="inline-flex items-center gap-2 bg-[#DB4437] text-white px-5 py-2.5 rounded-full font-semibold hover:bg-[#c63c31] transition-all duration-300 hover:shadow-lg"
                    >
                        Refine Search
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <a 
                        href="{{ route('homepage') }}" 
                        class="inline-flex items-center gap-2 text-[#DB4437] font-medium hover:underline"
                    >
                        Back to Homepage
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Active Filters -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10 mt-10">
        @if ($hasActiveFilters)
            <div class="bg-white border border-[#FFE7D6] rounded-3xl shadow-sm p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Active Filters</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($activeFilters as $label => $value)
                            <span class="inline-flex items-center gap-2 bg-[#FFF2E9] text-[#DB4437] px-3 py-1.5 rounded-full text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414 0L9 11.586 6.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z" clip-rule="evenodd" />
                                </svg>
                                <span class="font-semibold">{{ $label }}:</span> {{ $value }}
                            </span>
                        @endforeach
                    </div>
                </div>
                <button 
                    type="button"
                    data-search-overlay-open
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-[#FFE7D6] text-[#DB4437] font-medium hover:bg-[#FFE7D6] transition-all duration-300"
                >
                    Adjust Filters
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>
        @endif
    </section>

    <!-- Results -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10 py-12">
        @if ($properties->isEmpty())
            <div class="bg-white rounded-3xl shadow-md border border-dashed border-[#FFDCC4] p-10 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h2 class="mt-4 text-xl font-semibold text-gray-900">No properties found</h2>
                <p class="mt-2 text-gray-600">
                    Try adjusting your filters or broaden the search to see more options.
                </p>
                <div class="mt-6 flex justify-center">
                    <button 
                        type="button"
                        data-search-overlay-open
                        class="inline-flex items-center gap-2 bg-[#DB4437] text-white px-5 py-2.5 rounded-full font-semibold hover:bg-[#c63c31] transition-all duration-300 hover:shadow-lg"
                    >
                        Update Filters
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach ($properties as $property)
                    <article class="group bg-white rounded-3xl shadow hover:shadow-2xl transition-all duration-500 overflow-hidden">
                        <div class="relative">
                            <img 
                                src="{{ $property['image'] }}" 
                                alt="{{ $property['title'] }}" 
                                class="w-full h-56 object-cover transition-transform duration-700 group-hover:scale-110"
                            >
                            <span class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide bg-white/90 text-[#DB4437] shadow">
                                {{ \Illuminate\Support\Str::headline($property['type']) }}
                            </span>
                        </div>
                        <div class="p-5 sm:p-6 flex flex-col h-full">
                            <div class="flex items-center justify-between gap-3">
                                <h3 class="text-xl font-semibold text-gray-900 group-hover:text-[#DB4437] transition-colors duration-300">
                                    {{ $property['title'] }}
                                </h3>
                            </div>
                            <p class="mt-2 flex items-center gap-2 text-sm font-medium text-gray-500 uppercase tracking-wide">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DB4437]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                {{ $property['location'] }}
                            </p>
                            <p class="mt-4 text-2xl font-bold text-[#DB4437]">
                                {{ $formatPrice((int) $property['price']) }}
                            </p>
                            <div class="mt-4 grid grid-cols-2 gap-3 text-sm text-gray-600">
                                @if (($property['land_area'] ?? 0) > 0)
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7h16M4 12h16M4 17h16" />
                                        </svg>
                                        {{ $property['land_area'] }} m² land
                                    </div>
                                @endif
                                @if (($property['building_area'] ?? 0) > 0)
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7h18M3 12h18M3 17h18M8 3v4m8-4v4" />
                                        </svg>
                                        {{ $property['building_area'] }} m² building
                                    </div>
                                @endif
                                @if (($property['bedrooms'] ?? 0) > 0)
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7h18M5 7v10m14-10v10M7 17h10" />
                                        </svg>
                                        {{ $property['bedrooms'] }} Bedrooms
                                    </div>
                                @endif
                                @if (($property['bathrooms'] ?? 0) > 0)
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 19h14M6 5v5a2 2 0 002 2h8a2 2 0 002-2V5" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 9h14" />
                                        </svg>
                                        {{ $property['bathrooms'] }} Bathrooms
                                    </div>
                                @endif
                                @if (($property['garages'] ?? 0) > 0)
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12h18M5 12V7a2 2 0 012-2h10a2 2 0 012 2v5M5 16h2m10 0h2M6 16v2m10-2v2" />
                                        </svg>
                                        {{ $property['garages'] }} Parking
                                    </div>
                                @endif
                            </div>
                            <p class="mt-4 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($property['description'], 140) }}</p>
                            <div class="mt-5 flex flex-wrap gap-2">
                                @foreach (array_slice($property['specs'], 0, 4) as $spec)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#FFF2E9] text-[#DB4437] text-xs font-semibold">
                                        {{ $spec }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="mt-6">
                                <a 
                                    href="#"
                                    class="inline-flex items-center gap-2 text-[#DB4437] font-medium hover:text-[#c63c31] transition-colors duration-300"
                                >
                                    View Details
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    @include('components.property-search-overlay')
</x-app-layout>
