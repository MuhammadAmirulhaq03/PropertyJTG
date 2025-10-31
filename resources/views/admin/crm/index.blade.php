@php
    use Illuminate\Support\Str;
    $accent = '#0F766E';
    $accentSoft = '#CCFBF1';
@endphp

<x-admin.customer.layout selected-tab="crm">
    <div class="space-y-10">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#0F766E]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 14a4 4 0 10-8 0m8 0v1a4 4 0 01-4 4v0a4 4 0 01-4-4v-1m8 0a4 4 0 10-8 0M12 6a4 4 0 110 8 4 4 0 010-8z" /></svg>
                    {{ __('Customer Relationship Workspace') }}
                </h2>
                <p class="text-sm text-gray-500 max-w-xl">{{ __('Pantau status pelanggan dan tindak lanjuti mereka dengan cepat melalui pengingat jadwal maupun dokumen.') }}</p>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row">
                <a href="{{ route('admin.documents.index') }}"
                    class="inline-flex items-center gap-2 rounded-full border px-5 py-2.5 text-sm font-semibold transition hover:-translate-y-0.5"
                    style="background-color: {{ $accentSoft }}; color: {{ $accent }}; border-color: {{ $accent }}20;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h10m-6 6h12" />
                    </svg>
                    {{ __('Kelola Dokumen Pelanggan') }}
                </a>
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-600 transition hover:-translate-y-0.5 hover:border-gray-300 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2v-4" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    {{ __('Kembali ke Dashboard') }}
                </a>
            </div>
        </div>

        <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">{{ __('Total Pelanggan') }}</p>
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl" style="background-color: {{ $accentSoft }}; color: {{ $accent }};">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 14a4 4 0 10-8 0m8 0v1a4 4 0 01-4 4v0a4 4 0 01-4-4v-1m8 0a4 4 0 10-8 0M12 6a4 4 0 110 8 4 4 0 010-8z" /></svg>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
                <p class="mt-1 text-xs text-gray-500">{{ __('Semua akun pelanggan terdaftar') }}</p>
            </article>
            <article class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">{{ __('Sedang Online') }}</p>
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3" /></svg>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-bold" style="color: {{ $accent }};">{{ number_format($stats['online']) }}</p>
                <p class="mt-1 text-xs text-gray-500">{{ __('Login dalam 5 menit terakhir') }}</p>
            </article>
            <article class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">{{ __('Status Aktif') }}</p>
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" /></svg>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-bold text-gray-900">{{ number_format($stats['aktif']) }}</p>
                <p class="mt-1 text-xs text-gray-500">{{ __('Akun pelanggan aktif') }}</p>
            </article>
            <article class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">{{ __('Status Nonaktif') }}</p>
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gray-100 text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 6L6 18M6 6l12 12" /></svg>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-bold text-gray-900">{{ number_format($stats['nonaktif']) }}</p>
                <p class="mt-1 text-xs text-gray-500">{{ __('Perlu ditindaklanjuti atau verifikasi') }}</p>
            </article>
        </section>

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
            <form method="GET" action="{{ route('admin.crm.index') }}" class="grid gap-4 md:grid-cols-4 md:items-end">
                <input type="hidden" name="tab" value="crm">
                <div class="md:col-span-2">
                    <label for="search" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Pencarian pelanggan') }}</label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ $filters['search'] }}"
                        placeholder="{{ __('Cari nama, email, atau nomor telepon...') }}"
                        class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-{{ $accent }} focus:ring-{{ $accent }}"
                    >
                </div>
                <div>
                    <label for="status" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Status akun') }}</label>
                    <select name="status" id="status" class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-{{ $accent }} focus:ring-{{ $accent }}">
                        <option value="all" @selected($filters['status'] === 'all')>{{ __('Semua status') }}</option>
                        <option value="aktif" @selected($filters['status'] === 'aktif')>{{ __('Aktif') }}</option>
                        <option value="nonaktif" @selected($filters['status'] === 'nonaktif')>{{ __('Nonaktif') }}</option>
                    </select>
                </div>
                <div>
                    <label for="availability" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Ketersediaan') }}</label>
                    <select name="availability" id="availability" class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-{{ $accent }} focus:ring-{{ $accent }}">
                        <option value="all" @selected($filters['availability'] === 'all')>{{ __('Online & Offline') }}</option>
                        <option value="online" @selected($filters['availability'] === 'online')>{{ __('Hanya online') }}</option>
                        <option value="offline" @selected($filters['availability'] === 'offline')>{{ __('Hanya offline') }}</option>
                    </select>
                </div>
                <div class="md:col-span-4 flex flex-col gap-3 sm:flex-row sm:items-center">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#DB4437] px-6 py-2.5 text-sm font-semibold text-white shadow transition hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35M11 18a7 7 0 110-14 7 7 0 010 14z" />
                        </svg>
                        {{ __('Terapkan filter') }}
                    </button>
                    @if ($filters['search'] || $filters['status'] !== 'all' || $filters['availability'] !== 'all')
                        <a href="{{ route('admin.crm.index', ['tab' => 'crm']) }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700">
                            {{ __('Atur ulang filter') }}
                        </a>
                    @endif
                </div>
            </form>
        </section>

        <section class="rounded-3xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-xs font-semibold uppercase tracking-widest text-gray-500">
                            <th class="px-6 py-3">{{ __('Pelanggan') }}</th>
                            <th class="px-6 py-3">{{ __('Kontak') }}</th>
                            <th class="px-6 py-3">{{ __('Alamat') }}</th>
                            <th class="px-6 py-3">{{ __('Status') }}</th>
                            <th class="px-6 py-3 text-right">{{ __('Tindakan') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        @forelse ($customers as $customer)
                            <tr class="hover:bg-[#F8FAFC]">
                                <td class="px-6 py-4 align-top">
                                    <div class="flex items-start gap-3">
                                        <span class="mt-1 inline-flex h-2.5 w-2.5 rounded-full {{ $customer->is_online ? 'bg-emerald-400' : 'bg-gray-300' }}"></span>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $customer->name }}</p>
                                            <p class="text-xs text-gray-500">{{ __('Terakhir terlihat') }}: {{ $customer->last_seen_label }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-top space-y-2">
                                    <a href="{{ $customer->email_link }}" class="inline-flex items-center gap-2 text-[#2563EB] hover:text-[#1E3A8A]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 6l7.553 6.037a2 2 0 002.894 0L21 6M4 6v12h16V6" />
                                        </svg>
                                        {{ $customer->email }}
                                    </a>
                                    @if($customer->whatsapp_link)
                                        <a href="{{ $customer->whatsapp_link }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-[#16A34A] hover:text-[#166534]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12.04 2C6.57 2 2.1 6.26 2.1 11.61c0 1.85.54 3.58 1.48 5.07L2 22l5.52-1.44A9.88 9.88 0 0012.04 21c5.47 0 9.94-4.26 9.94-9.62C21.98 6.26 17.5 2 12.04 2Zm0 17.52c-1.73 0-3.34-.5-4.69-1.36l-.34-.21-3.27.85.87-3.12-.22-.33A7.64 7.64 0 014.4 11.6c0-4.18 3.46-7.58 7.64-7.58 4.21 0 7.64 3.4 7.64 7.58 0 4.18-3.43 7.58-7.64 7.58Zm4.48-5.7c-.24-.12-1.43-.71-1.65-.79-.22-.08-.38-.12-.54.12-.16.24-.62.79-.76.95-.14.16-.28.18-.52.06-.24-.12-1.02-.37-1.94-1.17-.72-.64-1.2-1.43-1.34-1.67-.14-.24-.01-.37.11-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.3-.74-1.78-.2-.48-.4-.42-.54-.42-.14 0-.3-.02-.46-.02-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2 0 1.18.86 2.32.98 2.48.12.16 1.68 2.68 4.07 3.76.57.25 1.02.4 1.36.51.57.18 1.08.16 1.49.1.45-.07 1.43-.58 1.63-1.14.2-.56.2-1.04.14-1.14-.06-.1-.24-.16-.48-.28Z" />
                                            </svg>
                                            {{ $customer->phone }}
                                        </a>
                                    @elseif($customer->phone)
                                        <span class="inline-flex items-center gap-2 text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8" />
                                            </svg>
                                            {{ $customer->phone }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">{{ __('Tidak ada nomor telepon') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <p class="text-sm text-gray-700">{{ $customer->alamat ?: __('Belum diisi') }}</p>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $customer->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-200 text-gray-600' }}">
                                        <span class="h-2 w-2 rounded-full {{ $customer->status === 'aktif' ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                        {{ Str::headline($customer->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right align-top">
                                    <div class="flex flex-col items-end gap-2">
                                        <a href="{{ $customer->document_reminder_link }}" class="inline-flex items-center gap-2 rounded-full border border-[#DB4437]/20 px-4 py-1.5 text-xs font-semibold text-[#DB4437] transition hover:bg-[#DB4437]/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12H9m0 0l3-3m-3 3l3 3" />
                                            </svg>
                                            {{ __('Ingatkan Dokumen') }}
                                        </a>
                                        <a href="{{ $customer->schedule_reminder_link }}" class="inline-flex items-center gap-2 rounded-full bg-[#0F766E] px-4 py-1.5 text-xs font-semibold text-white transition hover:bg-[#115E59]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-9a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z" />
                                            </svg>
                                            {{ __('Ingatkan Jadwal') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">
                                    {{ __('Belum ada data pelanggan yang sesuai dengan filter saat ini.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-admin.customer.layout>
