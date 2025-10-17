<x-app-layout>
    <div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-3xl border border-[#FFE7D6] p-10 text-center space-y-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[#DB4437]/10 text-[#DB4437]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <div class="space-y-2">
                <h1 class="text-3xl font-bold text-[#DB4437]">
                    {{ $title ?? __('Feature Coming Soon') }}
                </h1>
                <p class="text-gray-600">
                    {{ $message ?? __('We are preparing this customer feature to make your experience even better.') }}
                </p>
            </div>

            <div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#DB4437] text-white text-sm font-semibold hover:bg-[#c63c31] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7" />
                    </svg>
                    {{ $actionText ?? __('Back to dashboard') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

