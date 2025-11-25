<nav x-data="{ open: false }" class="fixed inset-x-0 top-0 z-40 bg-[#DB4437] text-white font-['Roboto'] shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-[auto,1fr,auto] items-center h-14 md:h-16">
            <!-- Logo + Nama Brand -->
            <div class="flex items-center space-x-3">
                <a href="/" class="flex items-center space-x-3">
                <img src="{{ asset('assets/jtg.png') }}" 
                    class="block h-9 md:h-10 w-auto p-0.5 rounded-lg ring ring-white ring-offset-0" 
                    alt="Logo">
                    <div class="leading-none">
                        <div class="text-base md:text-lg font-bold tracking-wide">JAYA TIBAR GROUP test</div>
                        <div class="text-[11px] md:text-xs text-gray-100 mt-0.5">Real Estate Management Platform</div>
                    </div>
                </a>
            </div>

            <!-- Navigation Links (slightly left of geometric center) -->
            <div class="hidden md:flex h-full items-center justify-center -ml-4 lg:-ml-8 space-x-8 text-sm font-semibold">
                <a href="/" class="hover:text-gray-100 {{ request()->is('/') ? 'underline font-semibold' : '' }}">Home Page</a>
                <a href="{{ route('house-view') }}" class="hover:text-gray-100 {{ request()->routeIs('house-view') ? 'underline font-semibold' : '' }}">House View</a>
                <a href="{{ route('gallery.index') }}" class="hover:text-gray-100 {{ request()->routeIs('gallery.*') ? 'underline font-semibold' : '' }}">{{ __('Galeri Properti') }}</a>
                @auth
                    @if (auth()->user()->hasRole('customer'))
                        <a href="{{ route('pelanggan.kpr.show') }}" class="hover:text-gray-100 {{ request()->routeIs('pelanggan.kpr.*') ? 'underline font-semibold' : '' }}">
                            Kalkulator KPR
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Right Side -->
            <div class="hidden md:flex h-full items-center space-x-4">
                @auth
                    @if (auth()->user()->hasRole('customer'))
                        <a
                            href="{{ route('dashboard') }}"
                            class="group relative inline-flex h-9 items-center gap-2 overflow-hidden rounded-full bg-white/15 px-4 text-sm font-semibold tracking-wide text-white transition hover:scale-105 hover:shadow-lg"
                        >
                            <span class="absolute inset-0 bg-gradient-to-r from-white/30 to-transparent opacity-0 transition group-hover:opacity-100"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="relative h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9.75l9-6 9 6M4.5 10.5v9.75h6V15h3v5.25h6V10.5" />
                            </svg>
                            <span class="relative">{{ __('Customer Dashboard') }}</span>
                        </a>
                    @elseif (auth()->user()->hasRole('admin'))
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="group relative inline-flex h-9 items-center gap-2 overflow-hidden rounded-full bg-white/15 px-4 text-sm font-semibold tracking-wide text-white transition hover:scale-105 hover:shadow-lg"
                        >
                            <span class="absolute inset-0 bg-gradient-to-r from-white/30 to-transparent opacity-0 transition group-hover:opacity-100"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="relative h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h10m-6 6h12" />
                            </svg>
                            <span class="relative">{{ __('Admin Workspace') }}</span>
                        </a>
                    @elseif (auth()->user()->hasRole('agen'))
                        <a
                            href="{{ route('agent.dashboard') }}"
                            class="group relative inline-flex h-9 items-center gap-2 overflow-hidden rounded-full bg-white/15 px-4 text-sm font-semibold tracking-wide text-white transition hover:scale-105 hover:shadow-lg"
                        >
                            <span class="absolute inset-0 bg-gradient-to-r from-white/30 to-transparent opacity-0 transition group-hover:opacity-100"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="relative h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h10m-6 6h12" />
                            </svg>
                            <span class="relative">{{ __('Agent Workspace') }}</span>
                        </a>
                    @endif

                    <!-- Dropdown User (hidden for admin; admin uses floating rail) -->
                    @if (! auth()->user()->hasRole('admin'))
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md bg-white text-[#DB4437] hover:bg-gray-100 focus:outline-none transition">
                                <div>{{ Auth::user()->display_name }}</div>
                                <svg class="ml-2 h-4 w-4 text-[#DB4437]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if (auth()->user()->hasRole('customer'))
                                <x-dropdown-link :href="route('documents.index')" class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6h18M3 12h18M7 18h10" />
                                    </svg>
                                    <span>{{ __('Pelanggan Center') }}</span>
                                </x-dropdown-link>
                            @elseif (auth()->user()->hasRole('admin'))
                                <x-dropdown-link :href="route('admin.crm.index')" class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6h18M3 12h18M7 18h10" />
                                    </svg>
                                    <span>{{ __('Customer CRM') }}</span>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.visit-schedules.index', ['tab' => 'visit-schedules'])" class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-9a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ __('Kelola Jadwal Kunjungan') }}</span>
                                </x-dropdown-link>
                            @elseif (auth()->user()->hasRole('agen'))
                                <x-dropdown-link :href="route('agent.documents.index')" class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6h18M3 12h18M7 18h10" />
                                    </svg>
                                    <span>{{ __('Document Verification') }}</span>
                                </x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A9 9 0 1118.9 17.806M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ __('Profile') }}</span>
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center gap-2 text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12H3m12 0l-4-4m4 4l-4 4m5 9a9 9 0 100-18 9 9 0 000 18z" />
                                    </svg>
                                    <span>{{ __('Log Out') }}</span>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="bg-white text-[#DB4437] px-4 py-2 rounded-md text-sm font-semibold hover:bg-gray-100 transition">Login</a>
                @endauth
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="flex justify-end md:hidden col-start-3 row-start-1">
                <button @click="open = ! open" class="p-2 rounded-md text-white hover:bg-[#C23321] focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-[#DB4437] text-white font-['Roboto']">
        <div class="px-4 pt-2 pb-3 space-y-2">
            <a href="/" class="block py-2 hover:text-gray-200">Home Page</a>
            <a href="{{ route('house-view') }}" class="block py-2 hover:text-gray-200">House View</a>
            <a href="{{ route('gallery.index') }}" class="block py-2 hover:text-gray-200">{{ __('Galeri Properti') }}</a>
        </div>

        <div class="border-t border-white/30 px-4 py-3">
            @auth
                <div class="font-semibold">{{ Auth::user()->display_name }}</div>
                <div class="text-sm text-white/80 mb-3">{{ Auth::user()->email }}</div>
                @if (auth()->user()->hasRole('customer'))
                    <x-responsive-nav-link :href="route('dashboard')" class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9.75l9-6 9 6M4.5 10.5v9.75h6V15h3v5.25h6V10.5" />
                        </svg>
                        {{ __('Customer Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('documents.index')" class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6h18M3 12h18M7 18h10" />
                        </svg>
                        {{ __('Pelanggan Center') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('pelanggan.kpr.show')" class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l4 2" />
                        </svg>
                        Kalkulator KPR
                    </x-responsive-nav-link>
                @elseif (auth()->user()->hasRole('admin'))
                    <x-responsive-nav-link :href="route('admin.dashboard')" class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h10m-6 6h12" />
                        </svg>
                        {{ __('Admin Workspace') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.crm.index')" class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6h18M3 12h18M7 18h10" />
                        </svg>
                        {{ __('Customer CRM') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.feedback.index')" class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h6M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v11a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 17.5v-11Z" />
                        </svg>
                        {{ __('Kelola Feedback') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.visit-schedules.index', ['tab' => 'visit-schedules'])" class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-9a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z" />
                        </svg>
                        {{ __('Kelola Jadwal Kunjungan') }}
                    </x-responsive-nav-link>
                @elseif (auth()->user()->hasRole('agen'))
                    <x-responsive-nav-link :href="route('agent.dashboard')" class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h10m-6 6h12" />
                        </svg>
                        {{ __('Agent Workspace') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('agent.documents.index')" class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6h18M3 12h18M7 18h10" />
                        </svg>
                        {{ __('Document Verification') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A9 9 0 1118.9 17.806M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-2 text-red-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12H3m12 0l-4-4m4 4l-4 4m5 9a9 9 0 100-18 9 9 0 000 18z" />
                        </svg>
                        Log Out
                    </x-responsive-nav-link>
                </form>
            @else
                <div class="flex h-full items-center">
                    <a href="{{ route('login') }}" class="inline-flex h-9 items-center rounded-md bg-white px-4 text-sm font-semibold text-[#DB4437] hover:bg-gray-100 transition">Login</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
