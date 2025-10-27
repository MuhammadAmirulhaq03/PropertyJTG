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
            <div class="mb-6 text-center md:text-left">
                <h1 class="text-2xl font-semibold text-gray-900">{{ __('Create Your Account') }}</h1>
                <p class="mt-2 text-sm text-gray-500">{{ __('Join to save favorites, book visits, and more.') }}</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mx-auto max-w-md md:mx-0">
                @csrf
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="phone" :value="__('Phone Number')" />
                    <x-text-input id="phone" class="mt-1 block w-full" type="text" name="phone" :value="old('phone')" required autocomplete="tel" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                    <x-primary-button>
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
