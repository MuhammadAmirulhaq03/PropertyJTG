<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <p class="text-sm uppercase tracking-[0.35em] text-gray-400 font-semibold">
                    {{ __('Agent Workspace') }}
                </p>
                <h2 class="mt-2 text-2xl md:text-3xl font-bold text-gray-900">
                    {{ __('Welcome back,') }}
                    <span class="text-[#DB4437]">
                        {{ Auth::user()?->name ?? __('Property Professional') }}
                    </span>
                </h2>
                <p class="mt-1 text-sm text-gray-500 max-w-2xl">
                    {{ __('Monitor listings, manage documents, and coordinate upcoming schedules for your clients.') }}
                </p>
            </div>
            <div class="flex items-center gap-4"></div>
        </div>
    </x-slot>

    <div class="bg-gradient-to-b from-white via-[#FFF7F1] to-white py-12">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:px-8">
            <!-- Highlight Banner -->
            <section class="relative overflow-hidden rounded-3xl bg-[#DB4437] text-white shadow-[0_25px_55px_rgba(219,68,55,0.25)]">
                <div class="absolute -top-16 right-[-60px] hidden h-64 w-64 rounded-full bg-white/10 blur-3xl md:block"></div>
                <div class="absolute -bottom-10 left-[-40px] hidden h-48 w-48 rounded-full bg-[#FFE7D6]/20 blur-2xl md:block"></div>

                <div class="relative grid gap-6 px-6 py-10 md:grid-cols-2 md:px-12 md:py-12">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.4em] text-white/70">
                            {{ __('Today\'s Focus') }}
                        </p>
                        <h3 class="mt-4 text-2xl font-bold md:text-3xl">
                            {{ __('Your property portfolio is looking great!') }}
                        </h3>
                        <p class="mt-3 text-sm md:text-base text-white/80 leading-relaxed">
                            {{ __('Review recent enquiries, update listing details, and keep documents in sync to deliver the best experience for your clients.') }}
                        </p>

                        <div class="mt-6 flex flex-wrap items-center gap-4">
                            <a
                                href="{{ route('gallery.index') }}"
                                class="inline-flex items-center gap-2 rounded-full bg-white/15 px-5 py-2 text-sm font-semibold text-white transition hover:bg-white/20"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                                </svg>
                                {{ __('Explore Properties') }}
                            </a>
                            <a
                                href="{{ route('agent.documents.index') }}"
                                class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2 text-sm font-semibold text-[#DB4437] transition hover:bg-[#FFE7D6]"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25m0 0L18 7.5m-2.25-2.25L15.75 3m-7.5 6V5.25m0 0L6 7.5m2.25-2.25L8.25 3M4.5 12h15m-12 6h9" />
                                </svg>
                                {{ __('Document Verification') }}
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 md:gap-6">
                        @foreach (($agentStats ?? []) as $stat)
                            <div class="flex flex-col rounded-2xl border border-white/20 bg-white/10 p-4 text-sm backdrop-blur-lg">
                                <span class="text-white/70">{{ $stat['title'] }}</span>
                                <span class="mt-2 text-2xl font-bold">{{ $stat['value'] }}</span>
                                <span class="mt-1 text-xs text-white/70">{{ $stat['change'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Admin spotlight -->
            @if (!empty($showAdminExtras))
                <section class="grid gap-6 rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-gray-200/40 md:grid-cols-3">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Team Performance Overview') }}</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            {{ __('Monitor sales activity across your agent network and identify opportunities that need attention.') }}
                        </p>
                    </div>
                    <div class="md:col-span-2 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl border border-gray-100 bg-gray-50/80 p-4">
                            <p class="text-sm text-gray-500">{{ __('Top Performing Agent') }}</p>
                            <p class="mt-2 text-xl font-semibold text-gray-900">Ivander Lukas</p>
                            <p class="text-xs text-[#DB4437] mt-1">{{ __('8 closed deals this quarter') }}</p>
                        </div>
                        <div class="rounded-2xl border border-gray-100 bg-gray-50/80 p-4">
                            <p class="text-sm text-gray-500">{{ __('Pipeline Health') }}</p>
                            <p class="mt-2 text-xl font-semibold text-gray-900">24 {{ __('active opportunities') }}</p>
                            <p class="text-xs text-[#DB4437] mt-1">{{ __('6 deals require financing approval') }}</p>
                        </div>
                        <div class="rounded-2xl border border-gray-100 bg-gray-50/80 p-4 sm:col-span-2">
                            <p class="text-sm text-gray-500">{{ __('Action Items') }}</p>
                            <ul class="mt-2 space-y-2 text-sm text-gray-600">
                                <li>• {{ __('Approve 3 pending agent registrations') }}</li>
                                <li>• {{ __('Review marketing budget for next month\'s launch') }}</li>
                                <li>• {{ __('Schedule all-hands meeting for project Summit Heights') }}</li>
                            </ul>
                        </div>
                    </div>
                </section>
            @endif

            <!-- Main Content -->
            <div class="grid gap-8 md:grid-cols-3">
                <section class="md:col-span-2 space-y-6">
                    <!-- Recent Activity -->
                    <div class="rounded-3xl bg-white p-6 shadow-lg shadow-gray-200/40">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ __('Recent Activity') }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ __('Your latest document reviews and visit bookings.') }}
                                </p>
                            </div>
                            <span class="text-xs font-semibold text-gray-400">{{ now()->translatedFormat('d M Y') }}</span>
                        </div>

                        <div class="mt-6 space-y-4">
                            @forelse (($recentActivities ?? collect()) as $activity)
                                <div class="flex items-start gap-4 rounded-2xl border border-gray-100 bg-gray-50/60 p-4 transition hover:border-[#DB4437]/30 hover:bg-white">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#FFE7D6] text-[#DB4437]">
                                        @if (($activity['type'] ?? '') === 'document_reviewed')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 10.5V6.75A2.25 2.25 0 0014.25 4.5h-6A2.25 2.25 0 006 6.75v10.5A2.25 2.25 0 008.25 19.5h7.5A2.25 2.25 0 0018 17.25V12" /></svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" /></svg>
                                        @endif
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-sm font-semibold text-gray-900">{{ $activity['title'] ?? '' }}</p>
                                        <p class="text-sm text-gray-500">{{ $activity['description'] ?? '' }}</p>
                                        <p class="text-xs font-medium text-[#DB4437]/80">{{ optional($activity['time'])->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-sm text-gray-500">
                                    {{ __('No recent activity') }}
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Quick Shortcuts removed per focus on documents and schedules -->
                </section>

                <!-- Side Column -->
                <aside class="space-y-6">
                    <!-- Upcoming Schedule -->
                    <div class="rounded-3xl bg-white p-6 shadow-lg shadow-gray-200/40">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Upcoming Schedule') }}</h3>
                            <span class="rounded-full bg-[#FFE7D6] px-3 py-1 text-xs font-semibold uppercase text-[#DB4437]">
                                {{ __('Bookings') }}: {{ $agentBookedCount ?? 0 }}
                            </span>
                        </div>
                        <div class="mt-6 space-y-4">
                            @forelse (($agentUpcoming ?? collect()) as $schedule)
                                <div class="flex gap-4 rounded-2xl border border-gray-100 bg-gray-50/80 p-4 transition hover:border-[#DB4437]/30 hover:bg-white">
                                    <div class="flex flex-col items-center justify-center rounded-2xl bg-white px-3 py-2 text-center shadow">
                                        <span class="text-xs font-semibold uppercase text-gray-400">{{ optional($schedule->start_at)->translatedFormat('D') }}</span>
                                        <span class="text-sm font-bold text-gray-900">{{ optional($schedule->start_at)->format('H:i') }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ __('Visit with') }} {{ optional($schedule->customer)->name ?? __('Customer') }}</p>
                                        <p class="text-xs text-gray-500">{{ $schedule->location ?? __('No location specified') }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-sm text-gray-500">
                                    {{ __('No upcoming visits') }}
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Support Card -->
                    <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-md shadow-gray-200/30">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Need Assistance?') }}</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            {{ __('Our support team is ready to help you with documentation checks, financing options, and marketing materials.') }}
                        </p>
                        <div class="mt-4 space-y-2 text-sm text-gray-700">
                            <p class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75l8.954 3.58a1.5 1.5 0 001.092 0l8.954-3.58m-18 0a1.5 1.5 0 01.566-.874L11.25 2.25a1.5 1.5 0 011.5 0l8.25 3.626a1.5 1.5 0 01.566.874m-18 0v10.5a1.5 1.5 0 00.879 1.372l7.5 3.214a1.5 1.5 0 001.242 0l7.5-3.214a1.5 1.5 0 00.879-1.372V6.75" />
                                </svg>
                                {{ __('support@propertyjtg.id') }}
                            </p>
                            <p class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 4.5A2.25 2.25 0 014.5 2.25h15a2.25 2.25 0 012.25 2.25v15a2.25 2.25 0 01-2.25 2.25h-15A2.25 2.25 0 012.25 19.5v-15zm5.25 0v15m0 0l4.5-4.5m-4.5 4.5L8.25 15m0 4.5L12 15" />
                                </svg>
                                {{ __('Download marketing toolkit') }}
                            </p>
                        </div>
                        <a
                            href="mailto:support@propertyjtg.id"
                            class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-[#DB4437] px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-[#DB4437]/30 transition hover:-translate-y-0.5 hover:bg-[#c63c31]"
                        >
                            {{ __('Contact Support Team') }}
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
