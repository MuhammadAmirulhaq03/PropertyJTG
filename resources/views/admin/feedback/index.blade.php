<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="space-y-2">
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#2563EB]">{{ __('Kelola Feedback') }}</p>
                <h1 class="text-2xl font-bold text-gray-900 md:text-3xl">{{ __('Pusat Feedback Pelanggan') }}</h1>
                <p class="text-sm text-gray-500 max-w-2xl">{{ __('Tinjau masukan pelanggan, identifikasi tren layanan, dan ekspor laporan untuk rapat tim Anda.') }}</p>
            </div>
            <div class="text-sm text-gray-500">
                <span class="font-semibold text-gray-900">{{ $stats['filtered'] }}</span> {{ __('feedback ditampilkan dari') }} <span class="font-semibold text-gray-900">{{ $stats['total'] }}</span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Total Feedback') }}</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
                <p class="text-xs text-gray-500">{{ __('Semua masukan pelanggan yang terekam.') }}</p>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Rata-rata Rating') }}</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($stats['avg_rating'], 1) }}</p>
                <p class="text-xs text-gray-500">{{ __('Dihitung dari seluruh penilaian yang masuk.') }}</p>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-400">{{ __('Sentimen Positif') }}</p>
                <p class="mt-2 text-3xl font-bold text-emerald-600">{{ number_format($stats['positive']) }}</p>
                <p class="text-xs text-gray-500">{{ __('Rating 4-5 dari pelanggan.') }}</p>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-widest text-rose-400">{{ __('Sentimen Negatif') }}</p>
                <p class="mt-2 text-3xl font-bold text-rose-600">{{ number_format($stats['negative']) }}</p>
                <p class="text-xs text-gray-500">{{ __('Rating 1-2 yang perlu perhatian lebih.') }}</p>
            </div>
        </section>

        @php
            $exportParams = collect($filters)
                ->reject(fn ($value, $key) => in_array($key, ['search', 'property_id', 'rating', 'mood', 'date_from', 'date_to']) && $value === '')
                ->toArray();
        @endphp

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm space-y-6">
            <form method="GET" class="grid gap-4 md:grid-cols-3 xl:grid-cols-6">
                <div class="md:col-span-2 xl:col-span-2">
                    <label for="search" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Pencarian') }}</label>
                    <input type="search" id="search" name="search" value="{{ $filters['search'] }}" placeholder="{{ __('Cari komentar / pesan pelanggan...') }}" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]" />
                </div>
                <div>
                    <label for="property_id" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Properti') }}</label>
                    <select name="property_id" id="property_id" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                        <option value="">{{ __('Semua properti') }}</option>
                        @foreach ($properties as $property)
                            <option value="{{ $property->id }}" @selected($filters['property_id'] == $property->id)>{{ $property->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="rating" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Rating') }}</label>
                    <select name="rating" id="rating" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                        <option value="">{{ __('Semua rating') }}</option>
                        @foreach (range(5, 1) as $rating)
                            <option value="{{ $rating }}" @selected((int) $filters['rating'] === $rating)>{{ $rating }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="mood" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Mood') }}</label>
                    <select name="mood" id="mood" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                        <option value="">{{ __('Semua mood') }}</option>
                        @foreach ($moods as $value => $label)
                            <option value="{{ $value }}" @selected((int) $filters['mood'] === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="date_from" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Dari Tanggal') }}</label>
                    <input type="date" id="date_from" name="date_from" value="{{ $filters['date_from'] }}" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]" />
                </div>
                <div>
                    <label for="date_to" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Sampai Tanggal') }}</label>
                    <input type="date" id="date_to" name="date_to" value="{{ $filters['date_to'] }}" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]" />
                </div>
                <div>
                    <label for="sort" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Urutkan') }}</label>
                    <select name="sort" id="sort" class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                        <option value="latest" @selected($filters['sort'] === 'latest')>{{ __('Terbaru') }}</option>
                        <option value="oldest" @selected($filters['sort'] === 'oldest')>{{ __('Terlama') }}</option>
                        <option value="highest_rating" @selected($filters['sort'] === 'highest_rating')>{{ __('Rating tertinggi') }}</option>
                        <option value="lowest_rating" @selected($filters['sort'] === 'lowest_rating')>{{ __('Rating terendah') }}</option>
                    </select>
                </div>
                <div class="flex items-end gap-2 md:col-span-3 xl:col-span-6 justify-end">
                    <a href="{{ route('admin.feedback.index') }}" class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 transition hover:border-gray-300 hover:text-gray-900">
                        {{ __('Reset') }}
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-[#2563EB] px-5 py-2 text-sm font-semibold text-white transition hover:-translate-y-0.5">
                        {{ __('Terapkan') }}
                    </button>
                    <a href="{{ route('admin.feedback.export', $exportParams) }}" class="inline-flex items-center gap-2 rounded-full border border-[#2563EB] px-5 py-2 text-sm font-semibold text-[#2563EB] transition hover:-translate-y-0.5 hover:bg-[#2563EB]/10">
                        {{ __('Export CSV') }}
                    </a>
                </div>
            </form>
        </section>

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm space-y-6">
            <div class="overflow-x-auto rounded-2xl border border-gray-100">
                <table class="min-w-[960px] divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-widest text-gray-500">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left">{{ __('Pelanggan') }}</th>
                            <th scope="col" class="px-4 py-3 text-left">{{ __('Properti') }}</th>
                            <th scope="col" class="px-4 py-3 text-left">{{ __('Rating') }}</th>
                            <th scope="col" class="px-4 py-3 text-left">{{ __('Mood') }}</th>
                            <th scope="col" class="px-4 py-3 text-left">{{ __('Feedback') }}</th>
                            <th scope="col" class="px-4 py-3 text-left">{{ __('Tanggal') }}</th>
                            <th scope="col" class="px-4 py-3 text-right">{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($feedbackItems as $feedback)
                            @php
                                $customer = $feedback->customer?->user;
                                $fullComment = trim($feedback->message ?? '') ?: trim($feedback->komentar ?? '');
                            @endphp
                            <tr class="align-top transition hover:bg-gray-50">
                                <td class="px-4 py-4">
                                    <div class="font-semibold text-gray-900">{{ $customer?->name ?? __('Tidak diketahui') }}</div>
                                    <div class="text-xs text-gray-500">{{ $customer?->email ?? 'N/A' }}</div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="font-semibold text-gray-900">{{ $feedback->properti?->nama ?? __('Tidak terkait properti') }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    @php
                                        $filledStars = str_repeat('?', (int) $feedback->rating);
                                        $emptyStars = str_repeat('?', max(0, 5 - (int) $feedback->rating));
                                    @endphp
                                    <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                        <span class="text-[#F59E0B]">{{ $filledStars }}<span class="text-gray-300">{{ $emptyStars }}</span></span>
                                        <span>{{ number_format($feedback->rating, 1) }}</span>
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ match((int) $feedback->mood) {
                                        3 => 'bg-emerald-50 text-emerald-700',
                                        2 => 'bg-amber-50 text-amber-700',
                                        1 => 'bg-rose-50 text-rose-700',
                                        default => 'bg-gray-100 text-gray-600',
                                    } }}">
                                        {{ $moods[$feedback->mood] ?? __('Tidak diketahui') }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-sm text-gray-600 line-clamp-2">{{ $fullComment !== '' ? $fullComment : __('Tidak ada keterangan tambahan.') }}</div>
                                    @if ($fullComment !== '')
                                        <details class="mt-2 text-xs">
                                            <summary class="cursor-pointer text-[#2563EB]">{{ __('Lihat detail') }}</summary>
                                            <div class="mt-2 whitespace-pre-line rounded-xl border border-gray-100 bg-gray-50 p-3 text-sm text-gray-600">{{ $fullComment }}</div>
                                        </details>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-semibold text-gray-900">{{ $feedback->tanggal ? \Illuminate\Support\Carbon::parse($feedback->tanggal)->translatedFormat('l, d M Y') : __('Tidak diketahui') }}</p>
                                    <p class="text-xs text-gray-500">{{ $feedback->created_at?->format('H:i') }}</p>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <form id="delete-feedback-{{ $feedback->id }}" method="POST" action="{{ route('admin.feedback.destroy', $feedback) }}" class="inline-flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-confirm-form="delete-feedback-{{ $feedback->id }}" data-confirm-title="{{ __('Hapus feedback?') }}" data-confirm-message="{{ __('Tindakan ini akan menghapus feedback pelanggan secara permanen.') }}" class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-white px-4 py-1 text-xs font-semibold text-red-600 transition hover:border-red-300 hover:bg-red-50 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            {{ __('Hapus') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-sm text-gray-500">
                                    {{ __('Belum ada feedback yang sesuai filter saat ini.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $feedbackItems->links() }}
        </section>
    </div>

    <!-- Confirm Delete Feedback Modal (red theme) -->
    <div id="confirm-delete-feedback-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
        <div class="fixed inset-0 flex min-h-full items-end sm:items-center justify-center p-4 sm:p-6">
            <div id="confirm-feedback-panel" class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 ring-1 ring-red-200">
                <div class="px-6 pt-6">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v4m0 4h.01M4.93 4.93a10 10 0 1114.14 14.14A10 10 0 014.93 4.93z" />
                        </svg>
                    </div>
                    <h3 id="confirm-feedback-title" class="mt-4 text-lg font-semibold text-gray-900">{{ __('Hapus data?') }}</h3>
                    <p id="confirm-feedback-message" class="mt-2 text-sm leading-relaxed text-gray-600">{{ __('Tindakan ini tidak dapat dibatalkan.') }}</p>
                </div>
                <div class="mt-6 flex items-center justify-end gap-3 border-t border-gray-100 px-6 py-4 bg-gray-50">
                    <button type="button" id="confirm-feedback-cancel" class="inline-flex justify-center rounded-full border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">{{ __('Batal') }}</button>
                    <button type="button" id="confirm-feedback-submit" class="inline-flex justify-center rounded-full bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600">{{ __('Hapus') }}</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('confirm-delete-feedback-modal');
            const panel = document.getElementById('confirm-feedback-panel');
            const title = document.getElementById('confirm-feedback-title');
            const message = document.getElementById('confirm-feedback-message');
            const btnCancel = document.getElementById('confirm-feedback-cancel');
            const btnSubmit = document.getElementById('confirm-feedback-submit');
            let targetFormId = null;

            function openModal(opts) {
                targetFormId = opts.formId;
                if (opts.title) title.textContent = opts.title;
                if (opts.message) message.textContent = opts.message;
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
                requestAnimationFrame(() => {
                    panel.classList.remove('opacity-0', 'translate-y-4', 'sm:scale-95');
                });
                btnSubmit.focus();
            }

            function closeModal() {
                panel.classList.add('opacity-0', 'translate-y-4', 'sm:scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                    targetFormId = null;
                }, 150);
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
            modal.addEventListener('click', function (e) {
                if (e.target === modal) closeModal();
            });
            btnSubmit.addEventListener('click', function () {
                if (!targetFormId) return closeModal();
                const form = document.getElementById(targetFormId);
                if (form) form.submit();
                closeModal();
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
            });
        })();
    </script>
</x-admin.layouts.app>
