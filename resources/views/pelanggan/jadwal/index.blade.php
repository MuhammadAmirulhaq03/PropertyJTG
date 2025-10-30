<x-app-layout>
    <section class="bg-[#FFF5EE] min-h-screen py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[280px_minmax(0,1fr)]">
                <aside class="bg-white rounded-3xl shadow-md border border-[#FFDCC4] overflow-hidden">
                    <div class="bg-[#DB4437] text-white px-6 py-6">
                        <p class="text-xs uppercase tracking-widest font-semibold">Customer Journey</p>
                        <p class="text-xl font-bold mt-1">Jadwal Kunjungan</p>
                        <p class="text-sm opacity-80 mt-3">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <nav class="px-5 py-6 space-y-2 text-sm text-gray-600">
                        @php
                            $customerLinks = [
                                ['label' => __('Customer Dashboard'), 'route' => route('dashboard'), 'active' => request()->routeIs('dashboard')],
                                ['label' => __('Home Page'), 'route' => route('homepage'), 'active' => request()->routeIs('homepage')],
                                ['label' => __('Document'), 'route' => route('documents.index'), 'active' => request()->routeIs('documents.*')],
                                ['label' => __('Feedback'), 'route' => route('pelanggan.feedback.create'), 'active' => request()->routeIs('pelanggan.feedback.*')],
                                ['label' => __('Konsultan Properti'), 'route' => route('pelanggan.consultants.create'), 'active' => request()->routeIs('pelanggan.consultants.*')],
                                ['label' => __('Pemesanan Kontraktor'), 'route' => route('pelanggan.contractors.create'), 'active' => request()->routeIs('pelanggan.contractors.*')],
                                ['label' => __('Jadwal Kunjungan'), 'route' => route('pelanggan.jadwal.index'), 'active' => request()->routeIs('pelanggan.jadwal.*')],
                                ['label' => __('Kalkulator KPR'), 'route' => route('pelanggan.kpr.show'), 'active' => request()->routeIs('pelanggan.kpr.*')],
                                ['label' => __('Favorit'), 'route' => route('pelanggan.favorit.index'), 'active' => request()->routeIs('pelanggan.favorit.*')],
                            ];
                        @endphp
                        @foreach ($customerLinks as $item)
                            <a href="{{ $item['route'] }}" class="flex items-center gap-3 px-3 py-2 rounded-2xl transition {{ $item['active'] ? 'bg-[#DB4437]/10 text-[#DB4437] font-semibold shadow-sm' : 'text-gray-600 hover:bg-[#FFF2E9]' }}">
                                <span class="w-2 h-2 rounded-full {{ $item['active'] ? 'bg-[#DB4437]' : 'bg-[#DB4437]/60' }}"></span>
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </nav>
                </aside>

                <div class="flex flex-col gap-8">
                    @if (session('success'))
                        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="rounded-3xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="bg-white rounded-3xl shadow-lg border border-[#FFE7D6] px-6 py-8 sm:px-10 sm:py-12">
                        <header class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div>
                                <h1 class="text-3xl font-bold text-[#DB4437]">{{ __('Slot Kunjungan Tersedia') }}</h1>
                                <p class="mt-2 text-gray-600 text-sm sm:text-base">
                                    {{ __('Pilih jadwal kunjungan yang tersedia. Setiap pelanggan hanya dapat membooking satu jadwal per hari.') }}
                                </p>
                            </div>
                            <div class="bg-[#FFF2E9] rounded-2xl px-4 py-3 text-xs sm:text-sm text-[#DB4437] font-medium shadow-sm">
                                {{ __('Slot akan ditutup otomatis ketika sudah dibooking pelanggan lainnya.') }}
                            </div>
                        </header>

                        <div class="mt-8 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                            @forelse ($availableSlots as $slot)
                                <form method="POST" action="{{ route('pelanggan.jadwal.book', $slot) }}" class="flex h-full flex-col justify-between gap-4 rounded-3xl border border-[#FFE7D6] bg-white p-6 shadow-sm">
                                    @csrf
                                    <div class="space-y-2">
                                        <span class="inline-flex items-center gap-2 rounded-full bg-[#DB4437]/10 px-3 py-1 text-xs font-semibold text-[#DB4437]">
                                            <span class="h-2 w-2 rounded-full bg-[#DB4437]"></span>
                                            {{ __('Agen') }} &middot; {{ $slot->agent->display_name }}
                                        </span>
                                        <p class="text-lg font-semibold text-gray-900">{{ $slot->start_at->translatedFormat('l, d F Y') }}</p>
                                        <p class="text-sm text-gray-600">{{ $slot->start_at->format('H:i') }} - {{ $slot->end_at->format('H:i') }} WIB</p>
                                        <p class="text-sm text-gray-500">
                                            <strong>{{ __('Lokasi') }}:</strong> {{ $slot->location ?? __('Belum ditentukan') }}
                                        </p>
                                        @if ($slot->notes)
                                            <p class="text-xs text-gray-500">
                                                <strong>{{ __('Catatan') }}:</strong> {{ $slot->notes }}
                                            </p>
                                        @endif
                                    </div>
                                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#DB4437] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#c63c31]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m6-6H6" />
                                        </svg>
                                        {{ __('Booking Jadwal') }}
                                    </button>
                                </form>
                            @empty
                                <div class="sm:col-span-2 xl:col-span-3 rounded-3xl border border-dashed border-[#FFE7D6] px-6 py-10 text-center text-sm text-gray-500">
                                    {{ __('Belum ada slot kunjungan yang tersedia saat ini. Silakan cek kembali atau hubungi tim kami.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-lg border border-[#FFE7D6] px-6 py-8 sm:px-10 sm:py-12">
                        <h2 class="text-2xl font-semibold text-[#DB4437]">{{ __('Jadwal Kunjungan Anda') }}</h2>
                        <p class="mt-2 text-sm text-gray-600">{{ __('Pantau dan kelola jadwal kunjungan yang sudah Anda booking.') }}</p>

                        <div class="mt-6 space-y-4">
                            @forelse ($myBookings as $booking)
                                <div class="border border-[#FFE7D6] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="space-y-1">
                                        <p class="text-sm font-semibold text-[#DB4437]">{{ $booking->agent->display_name }}</p>
                                        <p class="text-sm text-gray-600">{{ $booking->start_at->translatedFormat('l, d F Y') }} · {{ $booking->start_at->format('H:i') }} - {{ $booking->end_at->format('H:i') }} WIB</p>
                                        <p class="text-xs text-gray-500">{{ __('Lokasi') }}: {{ $booking->location ?? __('Belum ditentukan') }}</p>
                                        @if ($booking->notes)
                                            <p class="text-xs text-gray-500">{{ __('Catatan') }}: {{ $booking->notes }}</p>
                                        @endif
                                        <p class="text-xs text-gray-400">{{ __('Dibooking pada') }} {{ optional($booking->booked_at)->translatedFormat('d M Y H:i') }}</p>
                                    </div>
                                    <div class="flex items-center gap-3 self-start sm:self-auto">
                                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                            {{ __('Dibooking') }}
                                        </span>
                                        @if ($booking->start_at->isFuture())
                                            <form method="POST" action="{{ route('pelanggan.jadwal.cancel', $booking) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-red-100 px-4 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    {{ __('Batalkan') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-3xl border border-dashed border-[#FFE7D6] px-6 py-10 text-center text-sm text-gray-500">
                                    {{ __('Belum ada jadwal kunjungan yang Anda booking.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
