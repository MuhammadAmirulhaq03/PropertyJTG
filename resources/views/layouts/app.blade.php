<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            @include('layouts.footer')
        </div>
        @auth
        @php
            $mustChange = (auth()->user()->must_change_password ?? false) && auth()->user()->hasRole(['agen']);
            $onAllowedRoute = request()->routeIs('profile.*') || request()->routeIs('password.*');
        @endphp
        @if ($mustChange)
            <!-- Force-change-password overlay (shown when agent tries to access other pages or navigate back) -->
            <div id="force-change-overlay" class="fixed inset-0 z-[1000] hidden" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
                <div class="absolute inset-0 flex items-center justify-center p-6">
                    <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl ring-1 ring-red-200 p-6 text-center">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v4m0 4h.01M4.93 4.93a10 10 0 1114.14 14.14A10 10 0 014.93 4.93z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('UPDATE YOUR FIRST PASSWORD!') }}</h3>
                        <p class="mt-2 text-sm text-gray-600">{{ __('For security, please update your password before accessing other sections.') }}</p>
                        <div class="mt-5 flex justify-center">
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 rounded-full bg-[#DB4437] px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#c63c31]">
                                {{ __('Go to Update Password') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <script>
            (function () {
                const url = "{{ route('heartbeat') }}";
                function ping() {
                    try {
                        if (navigator.sendBeacon) {
                            navigator.sendBeacon(url, new Blob([], { type: 'application/octet-stream' }));
                        } else {
                            fetch(url, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: '' });
                        }
                    } catch (_) { /* noop */ }
                }
                // Initial ping on load and when tab becomes visible
                ping();
                document.addEventListener('visibilitychange', function(){ if (!document.hidden) ping(); });
                // Periodic ping every 60s
                setInterval(ping, 60000);
                // Optional: attempt to ping on unload
                window.addEventListener('beforeunload', ping);
            })();
        </script>
        @if ($mustChange)
        <script>
            (function () {
                const allowed = !!(@json($onAllowedRoute));
                const overlay = document.getElementById('force-change-overlay');
                function showOverlay() { if (overlay) overlay.classList.remove('hidden'); }
                // If we arrived here because middleware redirected us, optionally show a notice
                @if (session('must_change_password_block') || session('must_change_password_message'))
                    showOverlay();
                @endif
                // Block history-back cached pages (bfcache) and popstate when not on allowed routes
                if (!allowed) {
                    window.addEventListener('pageshow', function (e) {
                        if (e.persisted) {
                            showOverlay();
                            setTimeout(function(){ window.location.replace(@json(route('profile.edit'))); }, 50);
                        }
                    });
                    window.addEventListener('popstate', function () {
                        showOverlay();
                        setTimeout(function(){ window.location.replace(@json(route('profile.edit'))); }, 50);
                    });
                    // Also proactively show overlay to block interactions on non-allowed routes
                    showOverlay();
                } else {
                    // On the password/profile page itself, trap the back button and show the overlay
                    try {
                        history.pushState({ mustChange: true }, document.title, window.location.href);
                        window.addEventListener('popstate', function () {
                            showOverlay();
                            // Re-insert state and keep user on update page
                            try { history.pushState({ mustChange: true }, document.title, window.location.href); } catch (_) {}
                            setTimeout(function(){ window.location.replace(@json(route('profile.edit'))); }, 50);
                        });
                        window.addEventListener('pageshow', function (e) {
                            if (e.persisted) {
                                showOverlay();
                                setTimeout(function(){ window.location.replace(@json(route('profile.edit'))); }, 50);
                            }
                        });
                    } catch (_) { /* noop */ }
                }
            })();
        </script>
        @endif
        @endauth
    </body>
</html>
