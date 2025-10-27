@php
    $timeRange = $filters['range'] ?? '30';
    $propertyType = $filters['type'] ?? 'all';
    $location = $filters['location'] ?? 'all';
    $accent = '#B45309';
    $accentSoft = '#FEF3C7';
@endphp

<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="space-y-2">
                <p class="text-xs font-semibold uppercase tracking-[0.35em]" style="color: {{ $accent }};">
                    {{ __('Admin Workspace') }}
                </p>
                <h1 class="text-2xl font-bold text-gray-900 md:text-3xl">
                    {{ __('Portfolio Performance Overview') }}
                </h1>
                <p class="text-sm text-gray-500 max-w-2xl">
                    {{ __('Monitor property KPIs, identify lead trends, and keep stakeholders informed with the latest activity across the portfolio.') }}
                </p>
            </div>
            <div class="flex flex-wrap items-center justify-end gap-2">
                <a href="{{ route('admin.crm.index') }}"
                    class="inline-flex items-center gap-2 rounded-full border px-5 py-2.5 text-sm font-semibold transition hover:-translate-y-0.5"
                    style="background-color: {{ $accentSoft }}; color: {{ $accent }}; border-color: {{ $accent }}20;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h10m-6 6h12" />
                    </svg>
                    {{ __('Customer CRM') }}
                </a>
                @can('view-team-metrics')
                <a href="{{ route('admin.feedback.index') }}"
                    class="inline-flex items-center gap-2 rounded-full border px-5 py-2.5 text-sm font-semibold transition hover:-translate-y-0.5"
                    style="background-color: {{ $accentSoft }}; color: {{ $accent }}; border-color: {{ $accent }}20;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h6M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v11a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 17.5v-11Z" />
                    </svg>
                    {{ __('Kelola Feedback') }}
                </a>
                @endcan
                @can('manage-schedule')
                <a href="{{ route('admin.visit-schedules.index', ['tab' => 'visit-schedules']) }}"
                    class="inline-flex items-center gap-2 rounded-full border px-5 py-2.5 text-sm font-semibold transition hover:-translate-y-0.5"
                    style="background-color: {{ $accentSoft }}; color: {{ $accent }}; border-color: {{ $accent }}20;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" />
                    </svg>
                    {{ __('Kelola Jadwal Kunjungan') }}
                </a>
                @endcan
                <a href="{{ route('admin.requests.consultants.index') }}"
                    class="inline-flex items-center gap-2 rounded-full border px-5 py-2.5 text-sm font-semibold transition hover:-translate-y-0.5"
                    style="background-color: {{ $accentSoft }}; color: {{ $accent }}; border-color: {{ $accent }}20;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7v.01M12 7v.01M16 7v.01M3 12h18M7 21h10a2 2 0 0 0 2-2v-7H5v7a2 2 0 0 0 2 2Z" />
                    </svg>
                    {{ __('Permintaan Konsultan') }}
                </a>
                <a href="{{ route('admin.requests.contractors.index') }}"
                    class="inline-flex items-center gap-2 rounded-full border px-5 py-2.5 text-sm font-semibold transition hover:-translate-y-0.5"
                    style="background-color: {{ $accentSoft }}; color: {{ $accent }}; border-color: {{ $accent }}20;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7h18M5 7l1.5 12.5A2 2 0 0 0 8.5 21h7a2 2 0 0 0 1.99-1.75L19 7M9 10v7m6-7v7M8 7l2-4h4l2 4" />
                    </svg>
                    {{ __('Permintaan Kontraktor') }}
                </a>
                @can('manage-properties')
                <a href="{{ route('admin.properties.index') }}"
                    class="inline-flex items-center gap-2 rounded-full bg-[#B45309] px-5 py-2.5 text-sm font-semibold text-white transition hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m6-6H6" />
                    </svg>
                    {{ __('Kelola Listing') }}
                </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="space-y-14">
        <section class="rounded-[32px] bg-white shadow-sm border border-[#E2E8F0] px-8 py-6 space-y-6">
            <form method="GET" action="{{ route('admin.dashboard') }}"
                class="grid gap-5 md:grid-cols-4 md:items-end">
                <div class="space-y-1">
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                        {{ __('Time range') }}
                    </label>
                    <select name="range"
                        class="w-full rounded-2xl border-gray-200 text-sm focus:ring-{{ $accent }} focus:border-{{ $accent }}"
                        style="--tw-ring-color: {{ $accent }}; --tw-border-opacity: 0.6;">
                        <option value="7" @selected($timeRange === '7')>{{ __('Last 7 days') }}</option>
                        <option value="30" @selected($timeRange === '30')>{{ __('Last 30 days') }}</option>
                        <option value="90" @selected($timeRange === '90')>{{ __('Last 90 days') }}</option>
                        <option value="365" @selected($timeRange === '365')>{{ __('Year to date') }}</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                        {{ __('Property type') }}
                    </label>
                    <select name="type"
                        class="w-full rounded-2xl border-gray-200 text-sm focus:ring-{{ $accent }} focus:border-{{ $accent }}"
                        style="--tw-ring-color: {{ $accent }}; --tw-border-opacity: 0.6;">
                        <option value="all" @selected($propertyType === 'all')>{{ __('All types') }}</option>
                        <option value="house" @selected($propertyType === 'house')>{{ __('House') }}</option>
                        <option value="apartment" @selected($propertyType === 'apartment')>{{ __('Apartment') }}</option>
                        <option value="villa" @selected($propertyType === 'villa')>{{ __('Villa') }}</option>
                        <option value="commercial" @selected($propertyType === 'commercial')>{{ __('Commercial') }}</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                        {{ __('Location') }}
                    </label>
                    <select name="location"
                        class="w-full rounded-2xl border-gray-200 text-sm focus:ring-{{ $accent }} focus:border-{{ $accent }}"
                        style="--tw-ring-color: {{ $accent }}; --tw-border-opacity: 0.6;">
                        <option value="all" @selected($location === 'all')>{{ __('All locations') }}</option>
                        <option value="jakarta-selatan" @selected($location === 'jakarta-selatan')>{{ __('Jakarta Selatan') }}</option>
                        <option value="jakarta-pusat" @selected($location === 'jakarta-pusat')>{{ __('Jakarta Pusat') }}</option>
                        <option value="tangerang" @selected($location === 'tangerang')>{{ __('Tangerang') }}</option>
                        <option value="bandung" @selected($location === 'bandung')>{{ __('Bandung') }}</option>
                        <option value="bali" @selected($location === 'bali')>{{ __('Bali') }}</option>
                    </select>
                </div>
                <div class="flex flex-wrap items-center gap-3 md:justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold text-white shadow-sm transition"
                        style="background-color: {{ $accent }};">
                        {{ __('Apply filters') }}
                    </button>
                    <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold text-gray-600 transition"
                        style="border-color: {{ $accent }}30; color: {{ $accent }};">
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>
        </section>

        <section class="grid gap-10 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($kpis as $kpi)
                <article class="rounded-[28px] border border-[#E2E8F0] bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                {{ $kpi['label'] }}
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $kpi['value'] }}</p>
                            <p class="mt-2 text-xs font-semibold {{ $kpi['trend'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                <span class="inline-flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="{{ $kpi['trend'] >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}" />
                                    </svg>
                                    {{ $kpi['trend'] }}%
                                </span>
                                {{ __('vs previous period') }}
                            </p>
                        </div>
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl"
                            style="background-color: {{ $accentSoft }}; color: {{ $accent }};">
                            {!! $kpi['icon'] !!}
                        </span>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="grid gap-10 xl:grid-cols-12 items-start">
            <article class="rounded-[34px] border border-[#E2E8F0] bg-white p-8 shadow-sm xl:col-span-8">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Views & leads trend') }}</h3>
                    <span class="text-xs text-gray-400">{{ __('Dummy visualisation') }}</span>
                </div>

                <div class="mt-8 h-72">
                    <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="h-full w-full">
                        <defs>
                            <linearGradient id="viewsGradient" x1="0" x2="0" y1="0" y2="1">
                                <stop offset="0%" stop-color="{{ $accent }}" stop-opacity="0.25" />
                                <stop offset="100%" stop-color="{{ $accent }}" stop-opacity="0.02" />
                            </linearGradient>
                            <linearGradient id="leadsGradient" x1="0" x2="0" y1="0" y2="1">
                                <stop offset="0%" stop-color="#D97706" stop-opacity="0.25" />
                                <stop offset="100%" stop-color="#D97706" stop-opacity="0.02" />
                            </linearGradient>
                        </defs>
                        <rect x="0" y="0" width="100" height="100" fill="white" />
                        <path d="{{ $trend['paths']['views']['area'] }}" fill="url(#viewsGradient)" stroke="none" />
                        <path d="{{ $trend['paths']['views']['line'] }}" stroke="{{ $accent }}" stroke-width="1.2" fill="none" />
                        @foreach ($trend['paths']['views']['points'] as $point)
                            <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="1.2" fill="{{ $accent }}" />
                        @endforeach

                        <path d="{{ $trend['paths']['leads']['area'] }}" fill="url(#leadsGradient)" stroke="none" />
                        <path d="{{ $trend['paths']['leads']['line'] }}" stroke="#D97706" stroke-width="1.2" fill="none" />
                        @foreach ($trend['paths']['leads']['points'] as $point)
                            <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="1.2" fill="#D97706" />
                        @endforeach
                    </svg>
                </div>

                <div class="mt-8 grid gap-6 lg:grid-cols-2">
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 px-4 py-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            {{ __('Timeline') }}
                        </p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($trend['labels'] as $label)
                                <span class="rounded-full bg-white px-3 py-1 text-xs font-medium text-gray-600 shadow-sm">
                                    {{ $label }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 px-4 py-4 space-y-2">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            {{ __('Latest values') }}
                        </p>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center gap-2">
                                <span class="inline-block h-2 w-2 rounded-full" style="background: {{ $accent }}"></span>
                                {{ __('Views') }}: {{ number_format(end($trend['views'])) }}
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="inline-block h-2 w-2 rounded-full bg-[#D97706]"></span>
                                {{ __('Leads') }}: {{ number_format(end($trend['leads'])) }}
                            </li>
                        </ul>
                    </div>
                </div>
            </article>

            <article class="rounded-[34px] border border-[#E2E8F0] bg-white p-6 shadow-sm xl:col-span-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Lead sources breakdown') }}</h3>
                    <span class="text-xs text-gray-400">{{ __('Dummy percentages') }}</span>
                </div>
                <div class="mt-6 space-y-5">
                    @foreach ($leadSources['labels'] as $index => $label)
                        @php
                            $percentage = $leadSources['percentages'][$index] ?? 0;
                        @endphp
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="relative h-12 w-12 rounded-full"
                                    style="background: conic-gradient({{ $accent }} {{ $percentage * 3.6 }}deg, #E5E7EB 0deg);">
                                    <div class="absolute inset-1 rounded-full bg-white flex items-center justify-center text-xs font-semibold text-gray-600">
                                        {{ $percentage }}%
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $label }}</p>
                                    <p class="text-xs text-gray-500">{{ __('Leads') }}: {{ $leadSources['values'][$index] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>
        </section>

        <section class="grid gap-10 xl:grid-cols-12">
            <article class="rounded-[28px] border border-[#E2E8F0] bg-white p-6 shadow-sm xl:col-span-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Leads by channel') }}</h3>
                    <span class="text-xs text-gray-400">{{ __('Dummy data') }}</span>
                </div>
                <div class="mt-6 space-y-4">
                    @foreach ($leadsByChannel as $channel)
                        <div>
                            <div class="flex items-center justify-between text-sm font-semibold text-gray-700">
                                <span>{{ $channel['label'] }}</span>
                                <span>{{ $channel['value'] }}</span>
                            </div>
                            <div class="mt-2 h-2 rounded-full bg-[#E2E8F0]">
                                <div class="h-full rounded-full" style="width: {{ $channel['percentage'] }}%; background-color: {{ $accent }};"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>

            <article class="rounded-[28px] border border-[#E2E8F0] bg-white p-6 shadow-sm xl:col-span-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Top performing listings') }}</h3>
                    <span class="text-xs text-gray-400">{{ __('Sorted by views') }}</span>
                </div>
                <div class="mt-4 divide-y divide-gray-100">
                    @foreach ($topListings as $listing)
                        <div class="py-4 flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $listing['name'] }}</p>
                                <p class="text-xs text-gray-500">{{ $listing['location'] }} &bull; {{ $listing['type'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold" style="color: {{ $accent }};">{{ number_format($listing['views']) }} {{ __('views') }}</p>
                                <p class="text-xs text-gray-400">{{ $listing['leads'] }} {{ __('leads') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>

            <article class="rounded-[28px] border border-dashed p-8 text-center text-sm text-gray-500 xl:col-span-2"
                style="border-color: {{ $accent }}40; background-color: {{ $accentSoft }};">
                {{ __('Need more admin tools? Reserve this area for upcoming modules like financial summaries, staff performance, or campaign insights.') }}
            </article>
        </section>
    </div>
</x-admin.layouts.app>

