@php
    use Illuminate\Support\Str;

    $historyItems = ($searchHistories ?? collect())->take($limit ?? null);
@endphp

<div class="space-y-4" id="search-history">
    <div class="flex items-center justify-between gap-4">
        <h3 class="text-lg font-semibold text-gray-900">
            {{ __('Recent Searches') }}
        </h3>
        <a href="{{ route('properties.search') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-[#DB4437] hover:text-[#c63c31]">
            {{ __('New Search') }}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14m-7-7 7 7-7 7" />
            </svg>
        </a>
    </div>

    <div class="space-y-3">
        @forelse ($historyItems as $history)
            <article
                class="rounded-2xl border border-gray-100 bg-gray-50/80 p-4 transition hover:border-[#DB4437]/40 hover:bg-white">
                <div class="flex items-start justify-between gap-4">
                    <div class="space-y-2">
                        @php
                            $active = collect(data_get($history->filters, 'active', []));
                            $raw = collect(data_get($history->filters, 'raw', []));
                        @endphp

                        @if ($active->isNotEmpty())
                            <div class="flex flex-wrap gap-2">
                                @foreach ($active as $label => $value)
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full bg-[#FFE7D6] px-3 py-1 text-xs font-semibold text-[#DB4437]">
                                        {{ $label }}: {{ $value }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <dl class="flex flex-wrap gap-x-6 gap-y-2 text-xs text-gray-500">
                            @if ($raw->get('location'))
                                <div>
                                    <dt class="font-semibold text-gray-600">{{ __('Location') }}</dt>
                                    <dd>{{ $raw->get('location') }}</dd>
                                </div>
                            @endif
                            @if ($raw->get('type'))
                                <div>
                                    <dt class="font-semibold text-gray-600">{{ __('Type') }}</dt>
                                    <dd>{{ Str::headline($raw->get('type')) }}</dd>
                                </div>
                            @endif
                            @if ($raw->get('price_min') || $raw->get('price_max'))
                                <div>
                                    <dt class="font-semibold text-gray-600">{{ __('Budget') }}</dt>
                                    <dd>
                                        {{ $raw->get('price_min') ? 'min ' . number_format($raw->get('price_min'), 0, ',', '.') : '' }}
                                        {{ $raw->get('price_min') && $raw->get('price_max') ? ' · ' : '' }}
                                        {{ $raw->get('price_max') ? 'max ' . number_format($raw->get('price_max'), 0, ',', '.') : '' }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <span class="text-xs text-gray-400 whitespace-nowrap">
                        {{ $history->created_at->diffForHumans() }}
                    </span>
                </div>
            </article>
        @empty
            <p class="text-sm text-gray-500">
                {{ __('You have not searched for properties yet. Start exploring to see them here.') }}
            </p>
        @endforelse
    </div>
</div>
