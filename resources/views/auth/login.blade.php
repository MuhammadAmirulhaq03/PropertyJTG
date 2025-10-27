<x-guest-layout wide>
    <div class="grid min-h-[70vh] grid-cols-1 overflow-hidden rounded-3xl border border-[#FFE7D6] bg-white shadow-lg md:grid-cols-2">
        <!-- Image side -->
        <div class="relative hidden bg-[#DB4437]/5 md:block">
            <img src="{{ asset('assets/auth/jtg side login.png') }}" alt="{{ __('Inspiration') }}" class="absolute inset-0 h-full w-full object-cover" />
            <div class="absolute inset-0 bg-[#DB4437]/30 mix-blend-multiply"></div>
            <div class="relative z-10 flex h-full flex-col justify-end p-8 text-white">
                <h2 class="text-3xl font-extrabold leading-tight drop-shadow-sm sm:text-4xl">
                    {{ __('Bangun, Kolaborasi,') }} <span class="text-white/95">{{ __('Wujudkan!') }}</span>
                </h2>
                <p class="mt-3 text-sm text-white/90">{{ __('Property • Konsultan • Kontraktor') }}</p>
            </div>
        </div>

        <!-- Form side -->
        <div class="p-6 sm:p-10">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            @if (session('success') || session('error'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                     class="mb-4 rounded-md border p-3 text-sm"
                     :class="{ 'bg-green-100 border-green-400 text-green-700': '{{ session('success') }}', 'bg-red-100 border-red-400 text-red-700': '{{ session('error') }}' }">
                    {{ session('success') ?? session('error') }}
                </div>
            @endif

            <div class="mb-6 text-center md:text-left">
                <h1 class="text-2xl font-semibold text-gray-900">{{ __('Customer Sign In') }}</h1>
                <p class="mt-2 text-sm text-gray-500">
                    {{ __('Log in to continue your property journey. Company representatives should use the staff portal.') }}
                </p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="mx-auto max-w-md md:mx-0">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                    <x-primary-button>
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-gray-500 md:text-left">
                {{ __('Are you an agent or administrator?') }}
                <a href="{{ route('staff.login') }}" class="font-semibold text-[#DB4437] hover:text-[#c63c31]">
                    {{ __('Access the staff portal') }}
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
