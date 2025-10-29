@php
    $user = Auth::user();
    $name = $user?->display_name ?? $user?->name ?? 'Admin';

    $isActive = function($patterns) {
        $patterns = (array) $patterns;
        foreach ($patterns as $p) {
            if (request()->routeIs($p)) return true;
        }
        return false;
    };
@endphp

<aside class="space-y-4">
    <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Signed in as') }}</p>
        <p class="mt-1 text-lg font-bold text-gray-900">{{ $name }}</p>
    </div>

    <nav class="space-y-2">
        @can('manage-properties')
        <a href="{{ route('admin.properties.index') }}"
           class="group flex items-center justify-between rounded-2xl border px-4 py-3 text-sm font-semibold transition
                  {{ $isActive('admin.properties.*') ? 'bg-[#DB4437]/15 text-[#DB4437] border-[#DB4437]/30' : 'bg-[#DB4437]/10 text-[#DB4437] border-[#DB4437]/20 hover:bg-[#DB4437]/15' }}">
            <span class="inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l9-7 9 7v7a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                {{ __('Kelola Listing') }}
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70 group-hover:translate-x-0.5 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
        </a>
        @endcan

        @can('manage-schedule')
        <a href="{{ route('admin.visit-schedules.index', ['tab' => 'visit-schedules']) }}"
           class="group flex items-center justify-between rounded-2xl border px-4 py-3 text-sm font-semibold transition
                  {{ $isActive(['admin.visit-schedules.*']) ? 'bg-[#2563EB]/15 text-[#2563EB] border-[#2563EB]/30' : 'bg-[#2563EB]/10 text-[#2563EB] border-[#2563EB]/20 hover:bg-[#2563EB]/15' }}">
            <span class="inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ __('Kelola Jadwal Kunjungan') }}
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70 group-hover:translate-x-0.5 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
        </a>
        @endcan

        <a href="{{ route('admin.crm.index', ['tab' => 'crm']) }}"
           class="group flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-gray-300 hover:bg-gray-50 {{ $isActive('admin.crm.*') ? 'ring-1 ring-gray-200' : '' }}">
            <span class="inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6h18M3 12h18M7 18h10"/></svg>
                {{ __('Customer CRM') }}
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70 group-hover:translate-x-0.5 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
        </a>

        @can('view-team-metrics')
        <a href="{{ route('admin.feedback.index') }}"
           class="group flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-gray-300 hover:bg-gray-50 {{ $isActive('admin.feedback.*') ? 'ring-1 ring-gray-200' : '' }}">
            <span class="inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h6M4 6.5A2.5 2.5 0 016.5 4h11A2.5 2.5 0 0120 6.5v11a2.5 2.5 0 01-2.5 2.5h-11A2.5 2.5 0 014 17.5v-11z"/></svg>
                {{ __('Kelola Feedback') }}
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70 group-hover:translate-x-0.5 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
        </a>
        @endcan

        <a href="{{ route('admin.staff.agents.index') }}"
           class="group flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-gray-300 hover:bg-gray-50 {{ $isActive('admin.staff.agents.*') ? 'ring-1 ring-gray-200' : '' }}">
            <span class="inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 14a4 4 0 10-8 0m8 0v1a4 4 0 01-4 4v0a4 4 0 01-4-4v-1m8 0a4 4 0 10-8 0M12 6a4 4 0 110 8 4 4 0 010-8z"/></svg>
                {{ __('Staff → Agents') }}
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70 group-hover:translate-x-0.5 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
        </a>

        <a href="{{ route('admin.requests.consultants.index') }}"
           class="group flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-gray-300 hover:bg-gray-50 {{ $isActive('admin.requests.consultants.*') ? 'ring-1 ring-gray-200' : '' }}">
            <span class="inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7v.01M12 7v.01M16 7v.01M3 12h18M7 21h10a2 2 0 002-2v-7H5v7a2 2 0 002 2z"/></svg>
                {{ __('Permintaan Konsultan') }}
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70 group-hover:translate-x-0.5 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
        </a>

        <a href="{{ route('admin.requests.contractors.index') }}"
           class="group flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-gray-300 hover:bg-gray-50 {{ $isActive('admin.requests.contractors.*') ? 'ring-1 ring-gray-200' : '' }}">
            <span class="inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7h18M5 7l1.5 12.5A2 2 0 008.5 21h7a2 2 0 001.99-1.75L19 7M9 10v7m6-7v7M8 7l2-4h4l2 4"/></svg>
                {{ __('Permintaan Kontraktor') }}
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70 group-hover:translate-x-0.5 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
        </a>
    </nav>
</aside>

