@php
    $user = Auth::user();
    $name = $user?->display_name ?? $user?->name ?? 'Admin';
    $railDefaultCollapsed = config('admin.rail.collapsed_default', true) ? 'true' : 'false';

    $itemsTop = [
        [
            'label' => __('Kelola Listing'),
            'icon' => 'fa-solid fa-house',
            'route' => route('admin.properties.index'),
            'active' => request()->routeIs('admin.properties.*'),
            'accent' => 'red', // brand red
        ],
        [
            'label' => __('Kelola Jadwal Kunjungan'),
            'icon' => 'fa-solid fa-calendar-days',
            'route' => route('admin.visit-schedules.index', ['tab' => 'visit-schedules']),
            'active' => request()->routeIs('admin.visit-schedules.*'),
            'accent' => 'blue', // brand blue
        ],
    ];

    $items = [
        [
            'label' => __('Customer CRM'),
            'icon' => 'fa-solid fa-users',
            'route' => route('admin.crm.index', ['tab' => 'crm']),
            'active' => request()->routeIs('admin.crm.*'),
        ],
        [
            'label' => __('Kelola Feedback'),
            'icon' => 'fa-solid fa-comments',
            'route' => route('admin.feedback.index'),
            'active' => request()->routeIs('admin.feedback.*'),
        ],
        [
            'label' => __('Staff → Agents'),
            'icon' => 'fa-solid fa-id-badge',
            'route' => route('admin.staff.agents.index'),
            'active' => request()->routeIs('admin.staff.agents.*'),
        ],
        [
            'label' => __('Permintaan Konsultan'),
            'icon' => 'fa-solid fa-user-tie',
            'route' => route('admin.requests.consultants.index'),
            'active' => request()->routeIs('admin.requests.consultants.*'),
        ],
        [
            'label' => __('Permintaan Kontraktor'),
            'icon' => 'fa-solid fa-screwdriver-wrench',
            'route' => route('admin.requests.contractors.index'),
            'active' => request()->routeIs('admin.requests.contractors.*'),
        ],
    ];
@endphp

<div x-data="{
        collapsed: JSON.parse(localStorage.getItem('adminRailCollapsed') ?? '{{ $railDefaultCollapsed }}'),
        toggle(){ this.collapsed = !this.collapsed; localStorage.setItem('adminRailCollapsed', JSON.stringify(this.collapsed)); }
    }"
    class="fixed right-4 top-24 md:top-28 z-50">
    <div :style="collapsed ? 'width:3.5rem' : 'width:16rem'" style="width: {{ config('admin.rail.collapsed_default', true) ? '3.5rem' : '16rem' }}" class="transition-all duration-200">
        <div class="rounded-3xl border border-[#DB4437] bg-[#DB4437] text-white shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between px-3 py-3">
                <div class="truncate text-sm font-semibold text-white" x-show="!collapsed">{{ $name }}</div>
                <button x-on:click="toggle" type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-white/60 bg-white/95 text-[#DB4437] hover:bg-white" :title="collapsed ? '{{ __('Expand') }}' : '{{ __('Collapse') }}'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7" x-show="!collapsed"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" x-show="collapsed"></path>
                    </svg>
                </button>
            </div>

            <!-- Primary (accented) -->
            <nav class="px-2 pb-2 space-y-1">
                @foreach ($itemsTop as $it)
                    <a href="{{ $it['route'] }}" class="group flex items-center gap-3 rounded-2xl px-3 py-2 transition text-white {{ $it['active'] ? 'bg-white/20' : 'bg-white/10 hover:bg-white/15' }}" :title="collapsed ? '{{ $it['label'] }}' : ''" x-on:click.prevent="if ($event.metaKey || $event.ctrlKey || $event.button === 1) { return; } collapsed = true; localStorage.setItem('adminRailCollapsed','true'); window.location.href = $el.href;">
                        <i class="{{ $it['icon'] }} text-white text-[14px]"></i>
                        <span class="text-sm font-semibold" x-show="!collapsed">{{ $it['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="mx-3 my-2 border-t border-gray-100"></div>

            <!-- Standard items -->
            <nav class="px-2 py-2 space-y-1">
                @foreach ($items as $it)
                    <a href="{{ $it['route'] }}" class="group flex items-center gap-3 rounded-2xl px-3 py-2 text-white/90 transition hover:bg-white/10 {{ $it['active'] ? 'bg-white/15' : '' }}" :title="collapsed ? '{{ $it['label'] }}' : ''" x-on:click.prevent="if ($event.metaKey || $event.ctrlKey || $event.button === 1) { return; } collapsed = true; localStorage.setItem('adminRailCollapsed','true'); window.location.href = $el.href;">
                        <i class="{{ $it['icon'] }} text-white text-[14px]"></i>
                        <span class="text-sm font-semibold" x-show="!collapsed">{{ $it['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <!-- Footer actions -->
            <div class="px-2 pb-3">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-2xl px-3 py-2 text-sm font-semibold text-white hover:bg-white/10" :title="collapsed ? '{{ __('Profile') }}' : ''" x-on:click.prevent="if ($event.metaKey || $event.ctrlKey || $event.button === 1) { return; } collapsed = true; localStorage.setItem('adminRailCollapsed','true'); window.location.href = $el.href;">
                    <i class="fa-regular fa-user text-white text-[14px]"></i>
                    <span x-show="!collapsed">{{ __('Profile') }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button class="w-full flex items-center gap-3 rounded-2xl px-3 py-2 text-sm font-semibold text-white hover:bg-white/10" type="submit" :title="collapsed ? '{{ __('Logout') }}' : ''">
                        <i class="fa-solid fa-arrow-right-from-bracket text-white text-[14px]"></i>
                        <span x-show="!collapsed">{{ __('Logout') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
