<x-guest-layout wide>
    <div class="mx-auto max-w-6xl">
        <div class="grid min-h-[82vh] grid-cols-1 overflow-hidden rounded-[28px] border border-[#FFE7D6] bg-white shadow-xl md:grid-cols-2">
            <!-- Form side -->
            <div class="order-2 p-8 md:order-1 md:p-12">
                <!-- Brand -->
                <div class="mb-8 flex items-center gap-3">
                    <img src="{{ asset('assets/jtg.png') }}" class="h-12 w-12 rounded-xl" alt="JTG" />
                    <span class="text-sm font-semibold tracking-wide text-[#DB4437]">Jaya Tibar Group</span>
                </div>

                <!-- Title & Copy -->
                <div class="mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-900">
                        {{ __('Buat') }} <span class="text-[#DB4437]">{{ __('Password Baru.') }}</span>
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ __('Masukkan email dan password baru Anda untuk menyelesaikan proses reset.') }}
                    </p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="mx-auto max-w-md">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email Address')" />
                        <x-text-input id="email" placeholder="name@example.com" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#DB4437] focus:ring-[#DB4437]" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" placeholder="************" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#DB4437] focus:ring-[#DB4437]" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" placeholder="************" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#DB4437] focus:ring-[#DB4437]" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <button type="submit" class="inline-flex items-center justify-center rounded-full bg-[#DB4437] px-6 py-3 text-sm font-semibold text-white shadow-[0_6px_0_rgba(0,0,0,0.12)] transition hover:bg-[#c63c31]">
                            {{ __('Reset Password') }}
                        </button>
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-[#DB4437] hover:text-[#c63c31]">{{ __('Back to Login') }}</a>
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
                        {{ __('Pulihkan Akses') }}
                        <span class="block text-[#FDE3DF]">{{ __('dengan Password Baru') }}</span>
                    </h2>
                    <div class="mt-6 flex items-center gap-8 text-sm font-semibold">
                        <span>Property</span>
                        <span class="text-white/80">Konsultan</span>
                        <span>Kontraktor</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
