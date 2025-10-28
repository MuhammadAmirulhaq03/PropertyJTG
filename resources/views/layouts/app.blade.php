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
        @endauth
    </body>
</html>
