<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-gray-400">
                {{ __('Customer Dashboard') }}
            </p>
            <h2 class="text-2xl font-bold text-gray-900">
                {{ __('Welcome back, :name!', ['name' => Auth::user()?->name ?? __('Guest')]) }}
            </h2>
            <p class="text-sm text-gray-500 max-w-3xl">
                {{ __('Review your saved properties, upcoming visits, and document progress right here. Explore new listings whenever you are ready.') }}
            </p>
        </div>
    </x-slot>

    <div class="bg-gray-50 py-12">
        <div class="mx-auto grid max-w-6xl gap-8 px-4 sm:px-6 lg:px-8">
            <section class="grid gap-6 md:grid-cols-3">
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-600">{{ __('Saved Homes') }}</h3>
                        <span class="rounded-full bg-[#FFE7D6] px-3 py-1 text-xs font-semibold text-[#DB4437]">3</span>
                    </div>
                    <p class="mt-4 text-2xl font-bold text-gray-900">Cluster 15</p>
                    <p class="text-sm text-gray-500">
                        {{ __('Your recent favourites, ready for a second look or consultation.') }}
                    </p>
                    <a href="{{ url('/properties') }}" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-[#DB4437] hover:text-[#c63c31]">
                        {{ __('Browse more properties') }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-600">{{ __('Upcoming Visits') }}</h3>
                    <div class="mt-4 space-y-4">
                        <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4">
                            <p class="text-sm font-semibold text-gray-900">{{ __('City Garden Residence') }}</p>
                            <p class="text-xs text-gray-500">{{ __('Thursday, 10:00 AM | Meet with Agent Dimas') }}</p>
                        </div>
                        <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4">
                            <p class="text-sm font-semibold text-gray-900">{{ __('Sunrise Oaks Cluster') }}</p>
                            <p class="text-xs text-gray-500">{{ __('Saturday, 02:30 PM | Virtual Tour via Zoom') }}</p>
                        </div>
                    </div>
                    <a href="{{ url('/consultations') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-[#DB4437] hover:text-[#c63c31]">
                        {{ __('Manage appointments') }}
                    </a>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-600">{{ __('Document Status') }}</h3>
                    <ul class="mt-4 space-y-3 text-sm text-gray-600">
                        <li class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-green-500"></span>
                            {{ __('KTP and KK uploaded') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-yellow-400"></span>
                            {{ __('Salary slip pending verification') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-gray-300"></span>
                            {{ __('Bank statement yet to be uploaded') }}
                        </li>
                    </ul>
                    <a href="{{ url('/documents') }}" class="mt-6 inline-flex items-center gap-2 rounded-full bg-[#DB4437] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#c63c31]">
                        {{ __('Complete documents') }}
                    </a>
                </div>
            </section>

            <section class="rounded-3xl bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Recommended For You') }}</h3>
                        <p class="text-sm text-gray-500">
                            {{ __('Based on your saved homes and enquiry history.') }}
                        </p>
                    </div>
                    <a href="{{ url('/properties/search') }}" class="text-sm font-semibold text-[#DB4437] hover:text-[#c63c31]">
                        {{ __('View all recommendations') }}
                    </a>
                </div>
                <div class="mt-6 grid gap-6 md:grid-cols-3">
                    @foreach ([
                        ['name' => 'Lavanya Heritage', 'price' => 'Rp 845.000.000', 'location' => 'BSD City', 'image' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994'],
                        ['name' => 'Mahogany Park', 'price' => 'Rp 790.000.000', 'location' => 'Alam Sutera', 'image' => 'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde'],
                        ['name' => 'Emerald Hills', 'price' => 'Rp 910.000.000', 'location' => 'Summarecon', 'image' => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d'],
                    ] as $property)
                        <article class="group overflow-hidden rounded-2xl border border-gray-100 bg-gray-50 transition hover:-translate-y-1 hover:border-[#DB4437]/30 hover:bg-white">
                            <div class="relative h-40 overflow-hidden">
                                <img src="{{ $property['image'] }}" alt="{{ $property['name'] }}" class="h-full w-full object-cover transition group-hover:scale-105" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent opacity-0 transition group-hover:opacity-100"></div>
                            </div>
                            <div class="p-5 space-y-2">
                                <h4 class="text-lg font-semibold text-gray-900 group-hover:text-[#DB4437]">{{ $property['name'] }}</h4>
                                <p class="text-sm text-gray-500">{{ $property['location'] }}</p>
                                <p class="text-base font-bold text-[#DB4437]">{{ $property['price'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="grid gap-6 md:grid-cols-2">
                <div class="rounded-3xl bg-[#DB4437] p-6 text-white shadow-lg shadow-[#DB4437]/30">
                    <h3 class="text-lg font-semibold">{{ __('Need personalised assistance?') }}</h3>
                    <p class="mt-2 text-sm text-white/80">
                        {{ __('Our property consultants are ready to help you compare projects, financing schemes, and legal requirements.') }}
                    </p>
                    <a href="{{ url('/consultations') }}" class="mt-6 inline-flex items-center gap-2 rounded-full bg-white px-5 py-2 text-sm font-semibold text-[#DB4437] transition hover:bg-[#FFE7D6]">
                        {{ __('Book a consultation') }}
                    </a>
                </div>
                <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Latest Platform Updates') }}</h3>
                    <ul class="mt-4 space-y-3 text-sm text-gray-600">
                        <li>• {{ __('You can now track mortgage pre-approval progress in real time.') }}</li>
                        <li>• {{ __('New brochure added: Premium Acre Residences with flexible DP plans.') }}</li>
                        <li>• {{ __('Refer friends and earn rewards once their purchase completes.') }}</li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
