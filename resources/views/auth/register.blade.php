<x-guest-layout wide>
    <div class="mx-auto max-w-6xl">
        <div class="grid min-h-[82vh] grid-cols-1 overflow-hidden rounded-[28px] border border-[#FFE7D6] bg-white shadow-xl md:grid-cols-2">
            <!-- Form side -->
            <div class="order-2 p-8 md:order-1 md:p-12">
                <div class="mb-8 flex items-center gap-3">
                    <img src="{{ asset('assets/jtg.png') }}" class="h-12 w-12 rounded-xl" alt="JTG" />
                    <span class="text-sm font-semibold tracking-wide text-[#DB4437]">Jaya Tibar Group</span>
                </div>
                <div class="mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-900">{{ __('Create') }} <span class="text-[#DB4437]">{{ __('Account') }}</span></h1>
                    <p class="mt-2 text-sm text-gray-600">{{ __('Join to save favorites, book visits, and more.') }}</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="mx-auto max-w-md">
                    @csrf
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#DB4437] focus:ring-[#DB4437]" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#DB4437] focus:ring-[#DB4437]" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="phone" :value="__('Phone Number')" />
                        <x-text-input id="phone" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#DB4437] focus:ring-[#DB4437]" type="text" name="phone" :value="old('phone')" required autocomplete="tel" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#DB4437] focus:ring-[#DB4437]" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#DB4437] focus:ring-[#DB4437]" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                        <x-primary-button>
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Image side -->
            <div class="relative order-1 hidden bg-[#DB4437]/5 md:order-2 md:block">
                <div class="absolute inset-0 overflow-hidden rounded-s-[28px]">
                    <img src="{{ asset('assets/auth/jtg side login.png') }}" alt="{{ __('Inspiration') }}" class="h-full w-full select-none object-cover" />
                    <div class="absolute inset-0 bg-[#DB4437]/30"></div>
                </div>
                <div class="relative z-10 flex h-full flex-col justify-end p-10 pr-12 text-white">
                    <h2 class="text-4xl font-extrabold leading-tight drop-shadow-sm sm:text-5xl">
                        {{ __('Bangun,') }} {{ __('Kolaborasi,') }}
                        <span class="block text-[#FDE3DF]">{{ __('Wujudkan!') }}</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
