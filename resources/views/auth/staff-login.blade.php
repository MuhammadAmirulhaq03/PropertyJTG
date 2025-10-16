<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Staff Portal Sign In') }}</h1>
        <p class="mt-2 text-sm text-gray-500">
            {{ __('Only authorised administrators and agents may access this portal.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('staff.login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Company Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember my staff session') }}</span>
            </label>
        </div>

        <div class="mt-6 flex items-center justify-between text-sm">
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700">
                {{ __('Back to customer login') }}
            </a>
            <button type="submit" class="inline-flex items-center rounded-md bg-[#DB4437] px-4 py-2 font-semibold text-white shadow-sm transition hover:bg-[#c63c31]">
                {{ __('Sign in') }}
            </button>
        </div>
    </form>
</x-guest-layout>

