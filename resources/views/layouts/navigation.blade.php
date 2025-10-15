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
                <a href="/" class="hover:text-gray-100 {{ request()->is('/') ? 'underline font-semibold' : '' }}">Home</a>
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
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
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
            <a href="/" class="block py-2 hover:text-gray-200">Home</a>
            <a href="/buy" class="block py-2 hover:text-gray-200">Buy Home</a>
            <a href="/consultation" class="block py-2 hover:text-gray-200">Consultation</a>
            <a href="/about" class="block py-2 hover:text-gray-200">About</a>
        </div>

        <div class="border-t border-white/30 px-4 py-3">
            @auth
                <div class="font-semibold">{{ Auth::user()->name }}</div>
                <div class="text-sm text-white/80 mb-3">{{ Auth::user()->email }}</div>
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
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
