@php
    use Illuminate\Support\Str;
@endphp

<x-admin.customer.layout selected-tab="visit-schedules">
    <div class="space-y-10">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <section class="space-y-8">
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6">
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Total Jadwal') }}</p>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6h18M3 12h18M3 18h18" /></svg>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('Seluruh jadwal yang tercatat.') }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Jadwal Mendatang') }}</p>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" /></svg>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['upcoming'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('Slot aktif yang belum dimulai.') }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Slot Tersedia') }}</p>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" /></svg>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-bold text-emerald-600">{{ $stats['available'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('Siap dibagikan kepada pelanggan.') }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Slot Dibooking') }}</p>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0-1.657-1.343-3-3-3S6 9.343 6 11s1.343 3 3 3 3-1.343 3-3z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2" /></svg>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-bold text-[#DB4437]">{{ $stats['booked'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('Sedang menunggu kunjungan pelanggan.') }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Slot Ditutup') }}</p>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gray-100 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8h1a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2v-8a2 2 0 012-2h1" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 12V6a2 2 0 114 0v6" /></svg>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['closed'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('Sementara tidak tersedia untuk booking.') }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Kunjungan Selesai') }}</p>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" /></svg>
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-bold text-emerald-600">{{ $stats['completed'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('Jadwal yang sudah dikunjungi pelanggan.') }}</p>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-[360px_minmax(0,1fr)] 2xl:grid-cols-[380px_minmax(0,1fr)]">
                <article class="order-2 space-y-6 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm xl:order-1 xl:self-start">
                    <header>
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Tambah Jadwal Kunjungan') }}</h2>
                        <p class="text-xs text-gray-500">{{ __('Tentukan ketersediaan agen untuk pelanggan melakukan kunjungan.') }}</p>
                    </header>

                    <form method="POST" action="{{ route('admin.visit-schedules.store', ['tab' => 'visit-schedules']) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="agent_id" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Pilih agen') }}</label>
                            <select id="agent_id" name="agent_id" required class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]">
                                <option value="">{{ __('Pilih agen') }}</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}" @selected(old('agent_id') == $agent->id)>{{ $agent->display_name }} - {{ $agent->email }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="date" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Tanggal') }}</label>
                                <input type="date" id="date" name="date" value="{{ old('date', now()->toDateString()) }}" min="{{ now()->toDateString() }}" required class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]">
                            </div>
                            <div>
                                <label for="location" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Lokasi') }}</label>
                                <input type="text" id="location" name="location" value="{{ old('location') }}" placeholder="{{ __('cth. Kantor pusat / On-site') }}" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]">
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="start_time" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Waktu Mulai') }}</label>
                                <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}" required class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]">
                            </div>
                            <div>
                                <label for="end_time" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Waktu Selesai') }}</label>
                                <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}" required class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]">
                            </div>
                        </div>

                        <div>
                            <label for="notes" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Catatan') }}</label>
                            <textarea id="notes" name="notes" rows="3" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]" placeholder="{{ __('Keterangan tambahan untuk agen atau pelanggan.') }}">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-[#2563EB] px-5 py-2 text-sm font-semibold text-white transition hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m6-6H6" />
                            </svg>
                            {{ __('Simpan Jadwal') }}
                        </button>
                    </form>
                </article>

            <article class="order-1 rounded-3xl border border-gray-200 bg-white p-8 shadow-sm xl:order-2">
                    <header class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#DB4437]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" /></svg>
                                {{ __('Daftar Jadwal Kunjungan') }}
                            </h2>
                            <p class="text-xs text-gray-500">{{ __('Aturan: jeda 25 menit antar jadwal agen, maks 3 agen per slot, dan jadwal yang sudah dibooking tidak dapat diubah jamnya.') }}</p>
                        </div>
                    </header>

                    <form method="GET" action="{{ route('admin.visit-schedules.index') }}" class="mt-6 grid gap-4 md:grid-cols-3 xl:grid-cols-4">
                        <input type="hidden" name="tab" value="visit-schedules">
                        <div>
                            <label for="filter-date" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Tanggal') }}</label>
                            <input type="date" name="date" id="filter-date" value="{{ $filters['date'] }}" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]">
                        </div>
                        <div>
                            <label for="filter-status" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Status') }}</label>
                            <select name="status" id="filter-status" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]">
                                <option value="all" @selected($filters['status'] === 'all')>{{ __('Semua status') }}</option>
                                <option value="available" @selected($filters['status'] === 'available')>{{ __('Tersedia') }}</option>
                                <option value="booked" @selected($filters['status'] === 'booked')>{{ __('Dibooking') }}</option>
                                <option value="closed" @selected($filters['status'] === 'closed')>{{ __('Ditutup') }}</option>
                                <option value="completed" @selected($filters['status'] === 'completed')>{{ __('Selesai') }}</option>
                            </select>
                        </div>
                        <div>
                            <label for="filter-agent" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Agen') }}</label>
                            <select name="agent_id" id="filter-agent" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#DB4437] focus:ring-[#DB4437]">
                                <option value="">{{ __('Semua agen') }}</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}" @selected($filters['agent'] == $agent->id)>{{ $agent->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-3 xl:col-span-1 flex flex-col items-stretch gap-2 xl:items-end">
                            <a href="{{ route('admin.visit-schedules.index', ['tab' => 'visit-schedules']) }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 transition hover:border-gray-300 hover:text-gray-900">
                                {{ __('Reset') }}
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#DB4437] px-5 py-2 text-sm font-semibold text-white transition hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4.5h18M6 4.5v4.875a2.25 2.25 0 0 0 .659 1.591L9.75 14.25v5.25l4.5-1.5v-3.75l3.091-3.284A2.25 2.25 0 0 0 18 9.375V4.5" />
                                </svg>
                                {{ __('Terapkan') }}
                            </button>
                        </div>
                    </form>

                {{-- Mobile-friendly card list --}}
                <div class="mt-8 space-y-4 md:hidden">
                    @forelse ($schedules as $schedule)
                        @php
                            $badgeClasses = [
                                'available' => 'bg-emerald-50 text-emerald-600',
                                'booked' => 'bg-[#DB4437]/10 text-[#DB4437]',
                                'closed' => 'bg-gray-200 text-gray-600',
                                'completed' => 'bg-emerald-50 text-emerald-700',
                            ][$schedule->status] ?? 'bg-gray-200 text-gray-600';

                            $dotClasses = [
                                'available' => 'bg-emerald-500',
                                'booked' => 'bg-[#DB4437]',
                                'closed' => 'bg-gray-500',
                                'completed' => 'bg-emerald-600',
                            ][$schedule->status] ?? 'bg-gray-500';

                            $statusLabels = [
                                'available' => __('TERSEDIA'),
                                'booked' => __('DIBOOKING'),
                                'closed' => __('DITUTUP'),
                                'completed' => __('SELESAI'),
                            ];
                        @endphp
                        <article class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex flex-col gap-1">
                                    <span class="text-sm font-semibold text-gray-900">
                                        {{ $schedule->agent?->display_name ?? __('Tidak diketahui') }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $schedule->agent?->email ?? '—' }}
                                    </span>
                                </div>
                                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[11px] font-semibold {{ $badgeClasses }}">
                                    <span class="h-2 w-2 rounded-full {{ $dotClasses }}"></span>
                                    {{ $statusLabels[$schedule->status] ?? Str::upper($schedule->status) }}
                                </span>
                            </div>

                            @if ($schedule->customer)
                                <div class="mt-3 rounded-2xl bg-gray-50 p-3 text-xs text-gray-600">
                                    <p class="font-semibold text-gray-700">{{ __('Pelanggan') }}</p>
                                    <p class="mt-1 text-sm">{{ $schedule->customer->name }}</p>
                                    <p class="text-[11px] text-gray-400">{{ $schedule->customer->email }}</p>
                                </div>
                            @endif

                            <div class="mt-3 space-y-1 text-sm text-gray-700">
                                <p class="font-semibold">
                                    {{ $schedule->start_at->translatedFormat('l, d M Y') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $schedule->start_at->format('H:i') }} - {{ $schedule->end_at->format('H:i') }}
                                    <span class="ml-2 inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-[11px] font-semibold text-gray-600">
                                        {{ $schedule->durationMinutes() }} {{ __('menit') }}
                                    </span>
                                </p>
                                @if ($schedule->booked_at)
                                    <p class="text-[11px] uppercase tracking-[0.2em] text-gray-400">
                                        {{ __('Dibooking pada') }} {{ $schedule->booked_at->format('d M Y H:i') }}
                                    </p>
                                @endif
                            </div>

                            <div class="mt-3 text-sm text-gray-700">
                                <p class="font-semibold">
                                    {{ $schedule->location ?? __('Belum ditentukan') }}
                                </p>
                                @if ($schedule->notes)
                                    <p class="mt-2 rounded-2xl bg-gray-50 p-3 text-xs leading-relaxed text-gray-600">
                                        {{ $schedule->notes }}
                                    </p>
                                @endif
                            </div>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="{{ route('admin.visit-schedules.edit', $schedule) }}" class="inline-flex flex-1 items-center justify-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-600 transition hover:border-gray-300 hover:bg-gray-50 hover:text-gray-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                                    </svg>
                                    {{ __('Ubah') }}
                                </a>

                                @if ($schedule->status === 'available')
                                    <form method="POST" action="{{ route('admin.visit-schedules.close', $schedule) }}" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-amber-200 bg-white px-4 py-2 text-xs font-semibold text-amber-700 transition hover:border-amber-300 hover:bg-amber-50 hover:text-amber-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 12H6" />
                                            </svg>
                                            {{ __('Tutup slot') }}
                                        </button>
                                    </form>
                                @elseif ($schedule->status === 'closed')
                                    <form method="POST" action="{{ route('admin.visit-schedules.reopen', $schedule) }}" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-emerald-200 bg-white px-4 py-2 text-xs font-semibold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                                            </svg>
                                            {{ __('Buka slot') }}
                                        </button>
                                    </form>
                                @endif

                                @if ($schedule->isBooked())
                                    <span class="inline-flex flex-1 items-center justify-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 6L6 18" />
                                        </svg>
                                        {{ __('Tidak dapat dihapus') }}
                                    </span>
                                @else
                                    <form id="mobile-delete-schedule-{{ $schedule->id }}" method="POST" action="{{ route('admin.visit-schedules.destroy', $schedule) }}" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-confirm-form="mobile-delete-schedule-{{ $schedule->id }}" data-confirm-title="{{ __('Hapus Jadwal') }}" data-confirm-message="{{ __('Yakin ingin menghapus jadwal ini? Tindakan ini tidak dapat dibatalkan.') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-red-200 bg-white px-4 py-2 text-xs font-semibold text-red-600 transition hover:border-red-300 hover:bg-red-50 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            {{ __('Hapus') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </article>
                    @empty
                        <p class="py-6 text-center text-sm text-gray-500">
                            {{ __('Belum ada jadwal kunjungan yang sesuai filter.') }}
                        </p>
                    @endforelse
                </div>

                {{-- Desktop table --}}
                <div class="mt-8 hidden md:block">
                    <div class="overflow-x-auto rounded-2xl border border-gray-100">
                        <table class="min-w-[800px] divide-y divide-gray-100 text-[15px]">
                            <thead class="sticky top-0 z-10 bg-white/95 backdrop-blur text-xs font-semibold uppercase tracking-widest text-gray-500">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left">{{ __('Agen') }}</th>
                                    <th scope="col" class="px-4 py-3 text-left">{{ __('Waktu') }}</th>
                                    <th scope="col" class="px-4 py-3 text-left">{{ __('Lokasi & Catatan') }}</th>
                                    <th scope="col" class="px-4 py-3 text-left">{{ __('Status') }}</th>
                                    <th scope="col" class="px-4 py-3 text-right">{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse ($schedules as $schedule)
                                    <tr class="align-top odd:bg-gray-50/40 transition hover:bg-gray-50">
                                        <td class="px-4 py-4">
                                            <div class="flex flex-col gap-1">
                                                <span class="font-semibold text-gray-900">{{ $schedule->agent?->display_name ?? __('Tidak diketahui') }}</span>
                                                <span class="text-xs text-gray-500">{{ $schedule->agent?->email ?? '—' }}</span>
                                            </div>
                                            @if ($schedule->customer)
                                                <div class="mt-3 rounded-2xl bg-gray-50 p-3 text-xs text-gray-600">
                                                    <p class="font-semibold text-gray-700">{{ __('Pelanggan') }}</p>
                                                    <p class="mt-1">{{ $schedule->customer->name }}</p>
                                                    <p class="text-[11px] text-gray-400">{{ $schedule->customer->email }}</p>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            <p class="font-semibold text-gray-900">{{ $schedule->start_at->translatedFormat('l, d M Y') }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $schedule->start_at->format('H:i') }} - {{ $schedule->end_at->format('H:i') }}
                                                <span class="ml-2 inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-[11px] font-semibold text-gray-600">
                                                    {{ $schedule->durationMinutes() }} {{ __('menit') }}
                                                </span>
                                            </p>
                                            @if ($schedule->booked_at)
                                                <p class="mt-2 text-[11px] uppercase tracking-[0.2em] text-gray-400">
                                                    {{ __('Dibooking pada') }} {{ $schedule->booked_at->format('d M Y H:i') }}
                                                </p>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            <p class="font-semibold text-gray-900">{{ $schedule->location ?? __('Belum ditentukan') }}</p>
                                            @if ($schedule->notes)
                                                <p class="mt-2 rounded-2xl bg-gray-50 p-3 text-xs leading-relaxed text-gray-600">{{ $schedule->notes }}</p>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            @php
                                                $badgeClasses = [
                                                    'available' => 'bg-emerald-50 text-emerald-600',
                                                    'booked' => 'bg-[#DB4437]/10 text-[#DB4437]',
                                                    'closed' => 'bg-gray-200 text-gray-600',
                                                    'completed' => 'bg-emerald-50 text-emerald-700',
                                                ][$schedule->status] ?? 'bg-gray-200 text-gray-600';

                                                $dotClasses = [
                                                    'available' => 'bg-emerald-500',
                                                    'booked' => 'bg-[#DB4437]',
                                                    'closed' => 'bg-gray-500',
                                                    'completed' => 'bg-emerald-600',
                                                ][$schedule->status] ?? 'bg-gray-500';

                                                $statusLabels = [
                                                    'available' => __('TERSEDIA'),
                                                    'booked' => __('DIBOOKING'),
                                                    'closed' => __('DITUTUP'),
                                                    'completed' => __('SELESAI'),
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">
                                                <span class="h-2 w-2 rounded-full {{ $dotClasses }}"></span>
                                                {{ $statusLabels[$schedule->status] ?? Str::upper($schedule->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-right">
                                            <div class="flex flex-wrap items-center justify-end gap-2">
                                                <a href="{{ route('admin.visit-schedules.edit', $schedule) }}" class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-1 text-xs font-semibold text-gray-600 transition hover:border-gray-300 hover:bg-gray-50 hover:text-gray-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                                                    </svg>
                                                    {{ __('Ubah') }}
                                                </a>

                                                @if ($schedule->status === 'available')
                                                    <form method="POST" action="{{ route('admin.visit-schedules.close', $schedule) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="inline-flex items-center gap-2 rounded-full border border-amber-200 bg-white px-4 py-1 text-xs font-semibold text-amber-700 transition hover:border-amber-300 hover:bg-amber-50 hover:text-amber-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 12H6" />
                                                            </svg>
                                                            {{ __('Tutup slot') }}
                                                        </button>
                                                    </form>
                                                @elseif ($schedule->status === 'closed')
                                                    <form method="POST" action="{{ route('admin.visit-schedules.reopen', $schedule) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-white px-4 py-1 text-xs font-semibold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                                                            </svg>
                                                            {{ __('Buka slot') }}
                                                        </button>
                                                    </form>
                                                @endif

                                                @if ($schedule->isBooked())
                                                    <span class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-1 text-xs font-semibold text-gray-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 6L6 18" />
                                                        </svg>
                                                        {{ __('Tidak dapat dihapus') }}
                                                    </span>
                                                @else
                                                    <form id="delete-schedule-{{ $schedule->id }}" method="POST" action="{{ route('admin.visit-schedules.destroy', $schedule) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" data-confirm-form="delete-schedule-{{ $schedule->id }}" data-confirm-title="{{ __('Hapus Jadwal?') }}" data-confirm-message="{{ __('Tindakan ini akan menghapus jadwal kunjungan secara permanen.') }}" class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-white px-4 py-1 text-xs font-semibold text-red-600 transition hover:border-red-300 hover:bg-red-50 hover:text-red-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                            {{ __('Hapus') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-500">
                                            {{ __('Belum ada jadwal kunjungan yang sesuai filter.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                </article>
            </div>
        </section>
        <!-- Shared red confirm modal for schedule deletion -->
        <div id="confirm-schedule-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
            <div class="fixed inset-0 flex min-h-full items-end sm:items-center justify-center p-4 sm:p-6">
                <div id="confirm-schedule-panel" class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 ring-1 ring-red-200">
                    <div class="px-6 pt-6">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v4m0 4h.01M4.93 4.93a10 10 0 1114.14 14.14A10 10 0 014.93 4.93z" />
                            </svg>
                        </div>
                        <h3 id="confirm-schedule-title" class="mt-4 text-lg font-semibold text-gray-900">{{ __('Konfirmasi') }}</h3>
                        <p id="confirm-schedule-message" class="mt-2 text-sm leading-relaxed text-gray-600">{{ __('Tindakan ini akan menghapus jadwal.') }}</p>
                    </div>
                    <div class="mt-6 flex items-center justify-end gap-3 border-t border-gray-100 px-6 py-4 bg-gray-50">
                        <button type="button" id="confirm-schedule-cancel" class="inline-flex justify-center rounded-full border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">{{ __('Batal') }}</button>
                        <button type="button" id="confirm-schedule-submit" class="inline-flex justify-center rounded-full bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600">{{ __('Hapus') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            (function () {
                const modal = document.getElementById('confirm-schedule-modal');
                const panel = document.getElementById('confirm-schedule-panel');
                const title = document.getElementById('confirm-schedule-title');
                const message = document.getElementById('confirm-schedule-message');
                const btnCancel = document.getElementById('confirm-schedule-cancel');
                const btnSubmit = document.getElementById('confirm-schedule-submit');
                let targetFormId = null;

                function openModal(opts) {
                    targetFormId = opts.formId;
                    if (opts.title) title.textContent = opts.title;
                    if (opts.message) message.textContent = opts.message;
                    modal.classList.remove('hidden');
                    modal.setAttribute('aria-hidden', 'false');
                    requestAnimationFrame(() => { panel.classList.remove('opacity-0', 'translate-y-4', 'sm:scale-95'); });
                    btnSubmit.focus();
                }
                function closeModal() {
                    panel.classList.add('opacity-0', 'translate-y-4', 'sm:scale-95');
                    setTimeout(() => { modal.classList.add('hidden'); modal.setAttribute('aria-hidden', 'true'); targetFormId = null; }, 150);
                }
                document.addEventListener('click', function (e) {
                    const trigger = e.target.closest('[data-confirm-form]');
                    if (trigger) {
                        e.preventDefault();
                        openModal({
                            formId: trigger.getAttribute('data-confirm-form'),
                            title: trigger.getAttribute('data-confirm-title') || title.textContent,
                            message: trigger.getAttribute('data-confirm-message') || message.textContent,
                        });
                    }
                });
                btnCancel.addEventListener('click', closeModal);
                modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });
                btnSubmit.addEventListener('click', function () {
                    if (!targetFormId) return closeModal();
                    const form = document.getElementById(targetFormId);
                    if (form) form.submit();
                    closeModal();
                });
                document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal(); });
            })();
        </script>
        <script>
            (function(){
                const dateEl = document.getElementById('date');
                const startEl = document.getElementById('start_time');
                const endEl = document.getElementById('end_time');
                if(!dateEl || !startEl || !endEl) return;
                function pad(n){ return n.toString().padStart(2,'0'); }
                function updateMins(){
                    try {
                        const today = new Date();
                        const sel = new Date(dateEl.value + 'T00:00:00');
                        if (isNaN(sel.getTime())) return;
                        if (sel.toDateString() === today.toDateString()) {
                            const minStr = pad(today.getHours()) + ':' + pad(today.getMinutes());
                            startEl.min = minStr;
                            endEl.min = minStr;
                        } else {
                            startEl.removeAttribute('min');
                            endEl.removeAttribute('min');
                        }
                    } catch(_) {}
                }
                updateMins();
                dateEl.addEventListener('change', updateMins);
            })();
        </script>
    </div>
</x-admin.customer.layout>
