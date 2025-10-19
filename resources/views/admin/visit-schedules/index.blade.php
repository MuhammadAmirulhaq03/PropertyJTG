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
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-5">
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Total Jadwal') }}</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('Seluruh jadwal yang tercatat.') }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Jadwal Mendatang') }}</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['upcoming'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('Slot aktif yang belum dimulai.') }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Slot Tersedia') }}</p>
                    <p class="mt-2 text-2xl font-bold text-emerald-600">{{ $stats['available'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('Siap dibagikan kepada pelanggan.') }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Slot Dibooking') }}</p>
                    <p class="mt-2 text-2xl font-bold text-[#DB4437]">{{ $stats['booked'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('Sedang menunggu kunjungan pelanggan.') }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Slot Ditutup') }}</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['closed'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('Sementara tidak tersedia untuk booking.') }}</p>
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
                            <select id="agent_id" name="agent_id" required class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                                <option value="">{{ __('Pilih agen') }}</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}" @selected(old('agent_id') == $agent->id)>{{ $agent->name }} - {{ $agent->email }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="date" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Tanggal') }}</label>
                                <input type="date" id="date" name="date" value="{{ old('date', now()->toDateString()) }}" min="{{ now()->toDateString() }}" required class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                            </div>
                            <div>
                                <label for="location" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Lokasi') }}</label>
                                <input type="text" id="location" name="location" value="{{ old('location') }}" placeholder="{{ __('cth. Kantor pusat / On-site') }}" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="start_time" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Waktu Mulai') }}</label>
                                <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}" required class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                            </div>
                            <div>
                                <label for="end_time" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Waktu Selesai') }}</label>
                                <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}" required class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                            </div>
                        </div>

                        <div>
                            <label for="notes" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Catatan') }}</label>
                            <textarea id="notes" name="notes" rows="3" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]" placeholder="{{ __('Keterangan tambahan untuk agen atau pelanggan.') }}">{{ old('notes') }}</textarea>
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
                            <h2 class="text-lg font-semibold text-gray-900">{{ __('Daftar Jadwal Kunjungan') }}</h2>
                            <p class="text-xs text-gray-500">{{ __('Aturan: jeda 25 menit antar jadwal agen, maks 3 agen per slot, dan jadwal yang sudah dibooking tidak dapat diubah jamnya.') }}</p>
                        </div>
                    </header>

                    <form method="GET" action="{{ route('admin.visit-schedules.index') }}" class="mt-6 grid gap-4 md:grid-cols-3 xl:grid-cols-4">
                        <input type="hidden" name="tab" value="visit-schedules">
                        <div>
                            <label for="filter-date" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Tanggal') }}</label>
                            <input type="date" name="date" id="filter-date" value="{{ $filters['date'] }}" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                        </div>
                        <div>
                            <label for="filter-status" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Status') }}</label>
                            <select name="status" id="filter-status" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                                <option value="all" @selected($filters['status'] === 'all')>{{ __('Semua status') }}</option>
                                <option value="available" @selected($filters['status'] === 'available')>{{ __('Tersedia') }}</option>
                                <option value="booked" @selected($filters['status'] === 'booked')>{{ __('Dibooking') }}</option>
                                <option value="closed" @selected($filters['status'] === 'closed')>{{ __('Ditutup') }}</option>
                            </select>
                        </div>
                        <div>
                            <label for="filter-agent" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Agen') }}</label>
                            <select name="agent_id" id="filter-agent" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                                <option value="">{{ __('Semua agen') }}</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}" @selected($filters['agent'] == $agent->id)>{{ $agent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-3 xl:col-span-1 flex flex-col items-stretch gap-2 xl:items-end">
                            <a href="{{ route('admin.visit-schedules.index', ['tab' => 'visit-schedules']) }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 transition hover:border-gray-300 hover:text-gray-900">
                                {{ __('Reset') }}
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#2563EB] px-5 py-2 text-sm font-semibold text-white transition hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4.5h18M6 4.5v4.875a2.25 2.25 0 0 0 .659 1.591L9.75 14.25v5.25l4.5-1.5v-3.75l3.091-3.284A2.25 2.25 0 0 0 18 9.375V4.5" />
                                </svg>
                                {{ __('Terapkan') }}
                            </button>
                        </div>
                    </form>

                <div class="mt-8 overflow-x-auto rounded-2xl border border-gray-100">
                    <table class="min-w-[800px] divide-y divide-gray-100 text-sm">
                        <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-widest text-gray-500">
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
                                    <tr class="align-top transition hover:bg-gray-50">
                                        <td class="px-4 py-4">
                                            <div class="flex flex-col gap-1">
                                                <span class="font-semibold text-gray-900">{{ $schedule->agent?->name ?? __('Tidak diketahui') }}</span>
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
                                                ][$schedule->status] ?? 'bg-gray-200 text-gray-600';
                                            @endphp
                                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">
                                                <span class="h-2 w-2 rounded-full {{ $schedule->status === 'available' ? 'bg-emerald-500' : ($schedule->status === 'booked' ? 'bg-[#DB4437]' : 'bg-gray-500') }}"></span>
                                                {{ Str::upper($schedule->status) }}
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
                                                    <form method="POST" action="{{ route('admin.visit-schedules.destroy', $schedule) }}" onsubmit="return confirm('{{ __('Hapus jadwal ini?') }}');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-white px-4 py-1 text-xs font-semibold text-red-600 transition hover:border-red-300 hover:bg-red-50 hover:text-red-700">
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
                </article>
            </div>
        </section>
    </div>
</x-admin.customer.layout>

