<nav x-data="{ open: false }" class="bg-[#DB4437] text-white font-['Roboto'] shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo + Nama Brand -->
            <div class="flex items-center space-x-3">
                <a href="/" class="flex items-center space-x-3">
                <img src="{{ asset('assets/jtg.png') }}" 
                    class="block h-12 w-auto p-1 rounded " 
                    alt="Logo">
                    <div class="leading-tight">
                        <div class="text-lg font-bold tracking-wide">JAYA TIBAR GROUP</div>
                        <div class="text-xs text-gray-100">Real Estate Management Platform</div>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex space-x-8 text-sm font-medium">
                <a href="/" class="hover:text-gray-100 {{ request()->is('/') ? 'underline font-semibold' : '' }}">Home Page</a>
                <a href="/buy" class="hover:text-gray-100 {{ request()->is('buy') ? 'underline font-semibold' : '' }}">Buy Home</a>
                <a href="/consultation" class="hover:text-gray-100 {{ request()->is('consultation') ? 'underline font-semibold' : '' }}">Consultation</a>
                <a href="/about" class="hover:text-gray-100 {{ request()->is('about') ? 'underline font-semibold' : '' }}">About</a>
            </div>

            <!-- Right Side -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <!-- Dropdown User -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md bg-white text-[#DB4437] hover:bg-gray-100 focus:outline-none transition">
                                <div>{{ Auth::user()->name }}</div>
                                <svg class="ml-2 h-4 w-4 text-[#DB4437]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('documents.index')" class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6h18M3 12h18M7 18h10" />
                                </svg>
                                <span>{{ __('User Dashboard') }}</span>
                            </x-dropdown-link>
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
                @else
                    <a href="{{ route('login') }}" class="bg-white text-[#DB4437] px-4 py-2 rounded-md text-sm font-semibold hover:bg-gray-100 transition">Login</a>
                    <a href="{{ route('register') }}" class="border border-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-white hover:text-[#DB4437] transition">Register</a>
                @endauth
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="flex md:hidden">
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
            <a href="/buy" class="block py-2 hover:text-gray-200">Buy Home</a>
            <a href="/consultation" class="block py-2 hover:text-gray-200">Consultation</a>
            <a href="/about" class="block py-2 hover:text-gray-200">About</a>
        </div>

        <div class="border-t border-white/30 px-4 py-3">
            @auth
                <div class="font-semibold">{{ Auth::user()->name }}</div>
                <div class="text-sm text-white/80 mb-3">{{ Auth::user()->email }}</div>
                <x-responsive-nav-link :href="route('documents.index')" class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6h18M3 12h18M7 18h10" />
                    </svg>
                    User Dashboard
                </x-responsive-nav-link>
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
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('login') }}" class="bg-white text-[#DB4437] text-center px-4 py-2 rounded-md font-semibold hover:bg-gray-100 transition">Login</a>
                    <a href="{{ route('register') }}" class="border border-white text-center px-4 py-2 rounded-md font-semibold hover:bg-white hover:text-[#DB4437] transition">Register</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
