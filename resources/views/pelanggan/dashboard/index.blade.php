<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-gray-400">
                {{ __('Customer Dashboard') }}
            </p>
            <h2 class="text-2xl font-bold text-gray-900">
                {{ __('Welcome back, :name!', ['name' => Auth::user()?->display_name ?? __('Guest')]) }}
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
                        <span class="rounded-full bg-[#FFE7D6] px-3 py-1 text-xs font-semibold text-[#DB4437]">{{ $favoritesCount ?? 0 }}</span>
                    </div>
                    @if(($favoritesCount ?? 0) > 0)
                        <ul class="mt-4 space-y-3">
                            @foreach(($favorites ?? collect()) as $fav)
                                <li class="flex items-center gap-3">
                                    <div class="h-10 w-14 overflow-hidden rounded-md bg-gray-100">
                                        @if ($fav->primaryMediaUrl)
                                            <img src="{{ $fav->primaryMediaUrl }}" alt="{{ $fav->nama }}" class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $fav->nama }}</p>
                                        <p class="text-xs text-gray-500">Rp {{ number_format($fav->harga, 0, ',', '.') }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-5 flex items-center gap-3">
                            <a href="{{ route('pelanggan.favorit.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-[#2563EB] hover:text-[#1D4ED8]">
                                {{ __('Lihat semua favorit') }}
                            </a>
                            <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-[#DB4437] hover:text-[#c63c31]">
                                {{ __('Browse more properties') }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    @else
                        <p class="mt-4 text-sm text-gray-500">
                            {{ __('You haven\'t saved any homes yet.') }}
                        </p>
                        <a href="{{ route('gallery.index') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-[#DB4437] hover:text-[#c63c31]">
                            {{ __('Browse more properties') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endif
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-600">{{ __('Upcoming Visits') }}</h3>
                    @if(($upcomingCount ?? 0) > 0)
                        <div class="mt-4 space-y-4">
                            @foreach(($upcomingVisits ?? collect()) as $visit)
                                <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4">
                                    <p class="text-sm font-semibold text-gray-900">{{ optional($visit->start_at)->translatedFormat('l, d M Y') }} — {{ optional($visit->start_at)->format('H:i') }}–{{ optional($visit->end_at)->format('H:i') }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ __('With') }} {{ optional($visit->agent)->display_name ?? __('Agent') }}
                                        @if($visit->location)
                                            | {{ $visit->location }}
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-4 text-sm text-gray-500">{{ __('No upcoming appointments') }}</p>
                    @endif
                    <a href="{{ route('pelanggan.jadwal.index') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-[#DB4437] hover:text-[#c63c31]">
                        {{ __('Manage appointments') }}
                    </a>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-600">{{ __('Document Status') }}</h3>
                    <div class="mt-4 flex flex-wrap items-center gap-2 text-xs">
                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 font-semibold text-emerald-700">
                            {{ __('Approved') }}: {{ $documentSummary['approved'] ?? 0 }}
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 font-semibold text-amber-700">
                            {{ __('Needs Revision') }}: {{ $documentSummary['needs_revision'] ?? 0 }}
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-3 py-1 font-semibold text-red-700">
                            {{ __('Rejected') }}: {{ $documentSummary['rejected'] ?? 0 }}
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 font-semibold text-slate-700">
                            {{ __('Submitted') }}: {{ $documentSummary['submitted'] ?? 0 }}
                        </span>
                    </div>

                    @if(($missingDocuments ?? collect())->isNotEmpty())
                        <div class="mt-6">
                            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Not Uploaded Yet') }}</p>
                            <ul class="mt-2 list-disc pl-5 text-sm text-gray-600">
                                @foreach(($missingDocuments ?? collect())->take(5) as $label)
                                    <li>{{ $label }}</li>
                                @endforeach
                            </ul>
                            @if(($missingDocuments ?? collect())->count() > 5)
                                <p class="mt-1 text-xs text-gray-400">+ {{ ($missingDocuments ?? collect())->count() - 5 }} {{ __('others') }}</p>
                            @endif
                        </div>
                    @else
                        <p class="mt-6 text-sm text-emerald-700">{{ __('Great! You have uploaded all required documents.') }}</p>
                    @endif

                    <a href="{{ route('documents.index') }}" class="mt-6 inline-flex items-center gap-2 rounded-full bg-[#DB4437] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#c63c31]">
                        {{ __('Manage documents') }}
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
                    <a href="{{ route('gallery.index') }}" class="text-sm font-semibold text-[#DB4437] hover:text-[#c63c31]">
                        {{ __('View all recommendations') }}
                    </a>
                </div>
                <div class="mt-6 grid gap-6 md:grid-cols-3">
                    @forelse (($recommendedProperties ?? collect()) as $property)
                        <article class="group overflow-hidden rounded-2xl border border-gray-100 bg-gray-50 transition hover:-translate-y-1 hover:border-[#DB4437]/30 hover:bg-white">
                            <div class="relative h-40 overflow-hidden">
                                @if ($property->primaryMediaUrl)
                                    <img src="{{ $property->primaryMediaUrl }}" alt="{{ $property->nama }}" class="h-full w-full object-cover transition group-hover:scale-105" />
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gray-100 text-xs text-gray-500">
                                        {{ __('No image') }}
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent opacity-0 transition group-hover:opacity-100"></div>
                            </div>
                            <div class="p-5 space-y-2">
                                <h4 class="text-lg font-semibold text-gray-900 group-hover:text-[#DB4437]">{{ $property->nama }}</h4>
                                <p class="text-sm text-gray-500">{{ $property->lokasi }}</p>
                                <p class="text-base font-bold text-[#DB4437]">Rp {{ number_format($property->harga, 0, ',', '.') }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-sm text-gray-500">
                            {{ __('No recommendations available.') }}
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="grid gap-6 md:grid-cols-2">
                <div class="rounded-3xl bg-[#DB4437] p-6 text-white shadow-lg shadow-[#DB4437]/30">
                    <h3 class="text-lg font-semibold">{{ __('Need personalised assistance?') }}</h3>
                    <p class="mt-2 text-sm text-white/80">
                        {{ __('Our property consultants are ready to help you compare projects, financing schemes, and legal requirements.') }}
                    </p>
                    <a href="{{ route('pelanggan.consultants.create') }}" class="mt-6 inline-flex items-center gap-2 rounded-full bg-white px-5 py-2 text-sm font-semibold text-[#DB4437] transition hover:bg-[#FFE7D6]">
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
