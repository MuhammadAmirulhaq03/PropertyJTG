@php
    use Illuminate\Support\Carbon;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-gray-400">
                    {{ __('Agent Workspace') }}
                </p>
                <h2 class="mt-2 text-2xl md:text-3xl font-bold text-gray-900">
                    {{ __('Customer Document Reviews') }}
                </h2>
                <p class="mt-2 text-sm text-gray-500 max-w-2xl">
                    {{ __('Monitor each customer\'s document progress, spot the ones that need attention, and finalise approvals with confidence.') }}
                </p>
            </div>
            <a href="{{ route('agent.dashboard') }}"
                class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:-translate-y-0.5 hover:border-[#DB4437]/40 hover:text-[#DB4437]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12h18" />
                </svg>
                {{ __('Back to workspace') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-white via-[#FFF7F1] to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            @if (session('status'))
                <div
                    class="rounded-3xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            <section class="rounded-3xl bg-white shadow-sm border border-[#FFE7D6] p-6 space-y-6">
                <form method="GET" action="{{ route('agent.documents.index') }}"
                    class="grid gap-4 md:grid-cols-5 md:items-end">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            {{ __('Customer status') }}
                        </label>
                        <select name="status"
                            class="w-full rounded-2xl border-gray-200 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]">
                            <option value="">{{ __('All customers') }}</option>
                            @foreach ($statusLabels as $value => $label)
                                <option value="{{ $value }}"
                                    @selected($filters['status'] === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            {{ __('Document type') }}
                        </label>
                        <select name="document_type"
                            class="w-full rounded-2xl border-gray-200 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]">
                            <option value="">{{ __('All types') }}</option>
                            @foreach ($documentTypes as $value => $label)
                                <option value="{{ $value }}"
                                    @selected($filters['document_type'] === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            {{ __('Requirement') }}
                        </label>
                        <select name="requirement"
                            class="w-full rounded-2xl border-gray-200 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]">
                            <option value="">{{ __('All') }}</option>
                            <option value="required" @selected(($filters['requirement'] ?? '') === 'required')>{{ __('Required') }}</option>
                            <option value="optional" @selected(($filters['requirement'] ?? '') === 'optional')>{{ __('Optional') }}</option>
                        </select>
                    </div>
                    <div class="space-y-1 md:col-span-2">
                        <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            {{ __('Search customers') }}
                        </label>
                        <div
                            class="flex rounded-2xl border border-gray-200 overflow-hidden shadow-sm focus-within:border-[#DB4437] focus-within:ring-1 focus-within:ring-[#DB4437]">
                            <span class="flex items-center px-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                                </svg>
                            </span>
                            <input type="search" name="search" value="{{ $filters['search'] }}"
                                placeholder="{{ __('Search by name or email') }}"
                                class="flex-1 border-0 text-sm focus:ring-0">
                        </div>
                    </div>
                    <div class="md:col-span-5 flex flex-wrap items-center gap-3">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-[#DB4437] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#c63c31]">
                            {{ __('Apply filters') }}
                        </button>
                        <a href="{{ route('agent.documents.index') }}"
                            class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 transition hover:border-[#DB4437]/40 hover:text-[#DB4437]">
                            {{ __('Reset') }}
                        </a>
                    </div>
                </form>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($statusLabels as $statusValue => $label)
                        <div
                            class="rounded-2xl border border-gray-100 bg-gray-50/80 p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-[#DB4437]/30 hover:bg-white">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $label }}</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900">{{ $statusMetrics[$statusValue] ?? 0 }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="space-y-4">
                @forelse ($customers as $entry)
                    @php
                        /** @var \App\Models\User $customer */
                        $customer = $entry['user'];
                        $latest = $entry['latest_update'] ? Carbon::parse($entry['latest_update']) : null;
                        $query = array_filter($filters);
                    @endphp
                    <article
                        class="rounded-3xl border border-[#FFE7D6] bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                            <div class="space-y-2">
                                <div class="flex flex-wrap items-center gap-3">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $customer->name ?? __('Unknown customer') }}
                                    </h3>
                                    <span
                                        class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $entry['overall_badge'] }}">
                                        {{ $entry['overall_label'] }}
                                    </span>
                                </div>
                                @if ($customer->email)
                                    <p class="text-sm text-gray-500">{{ $customer->email }}</p>
                                @endif
                            </div>
                            <div class="text-sm text-gray-500 space-y-1 text-right">
                                <div>{{ __('Documents uploaded') }}: <span class="font-semibold text-gray-900">{{ $entry['total_documents'] }}</span></div>
                                <div>{{ __('Pending review') }}: <span class="font-semibold text-[#DB4437]">{{ $entry['submitted_count'] }}</span></div>
                                <div>{{ __('Needs attention') }}: <span class="font-semibold text-red-600">{{ $entry['revision_count'] }}</span></div>
                                <div>{{ __('Approved') }}: <span class="font-semibold text-emerald-600">{{ $entry['approved_count'] }}</span></div>
                                <div class="text-xs text-gray-400">
                                    {{ __('Last update') }}:
                                    {{ $latest ? $latest->diffForHumans() : __('N/A') }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <a href="{{ route('agent.documents.show', array_merge(['user' => $customer->id], $query)) }}"
                                class="inline-flex items-center gap-2 rounded-full bg-[#DB4437] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#c63c31]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 12H3m12 0l-4-4m4 4l-4 4" />
                                </svg>
                                {{ __('Review documents') }}
                            </a>
                        </div>
                    </article>
                @empty
                    <div
                        class="rounded-3xl border border-dashed border-[#DB4437]/40 bg-white/60 p-10 text-center text-sm text-gray-500">
                        {{ __('No customers match the selected filters. Try broadening your search criteria.') }}
                    </div>
                @endforelse

                <div>
                    {{ $customers->links() }}
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
