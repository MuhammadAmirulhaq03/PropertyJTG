<x-admin.layouts.app>
    <div class="space-y-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">{{ __('Permintaan Kontraktor') }}</h1>
                <p class="text-sm text-gray-500">{{ __('Daftar permintaan pemesanan tim kontraktor dari pelanggan.') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.requests.contractors.export', request()->query()) }}" class="inline-flex items-center gap-2 rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow ring-1 ring-gray-200 hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
                    {{ __('Export CSV') }}
                </a>
            </div>
        </div>

        <form method="GET" class="grid gap-2 sm:grid-cols-2 lg:grid-cols-6">
            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="{{ __('Cari nama/email/telepon/area/kata kunci') }}" class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 lg:col-span-3">
            <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            <div class="flex items-center gap-2">
                <button type="submit" class="inline-flex items-center rounded-md bg-[#DB4437] px-3 py-2 text-sm font-semibold text-white shadow hover:bg-[#c63c31]">{{ __('Filter') }}</button>
                @if (request()->hasAny(['search','date_from','date_to']))
                    <a href="{{ route('admin.requests.contractors.index') }}" class="text-sm text-gray-600 hover:text-gray-800">{{ __('Reset') }}</a>
                @endif
            </div>
        </form>

        <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">{{ __('Tanggal') }}</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">{{ __('Nama') }}</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">{{ __('Kontak') }}</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">{{ __('Area / Luas') }}</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">{{ __('Titik Lokasi') }}</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">{{ __('Pesan') }}</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($items as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 whitespace-nowrap text-gray-700">{{ optional($row->created_at)->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-2 font-medium text-gray-900">{{ $row->nama }}</td>
                                <td class="px-4 py-2 text-gray-700">
                                    <div>{{ $row->email }}</div>
                                    <div class="text-xs text-gray-500">{{ $row->phone }}</div>
                                </td>
                                <td class="px-4 py-2 text-gray-700">{{ $row->luas_bangunan_lahan ?: '-' }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ $row->titik_lokasi ?: '-' }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ \Illuminate\Support\Str::limit($row->pesan ?: '-', 80) }}</td>
                                <td class="px-4 py-2 text-right">
                                    <form id="delete-contractor-{{ $row->id }}" method="POST" action="{{ route('admin.requests.contractors.destroy', $row) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-confirm-form="delete-contractor-{{ $row->id }}" data-confirm-title="{{ __('Hapus permintaan?') }}" data-confirm-message="{{ __('Tindakan ini tidak dapat dibatalkan.') }}" class="inline-flex items-center rounded-md bg-white px-3 py-1.5 text-xs font-medium text-red-600 shadow ring-1 ring-red-200 hover:bg-red-50">{{ __('Hapus') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">{{ __('Belum ada data.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-gray-100 p-3">{{ $items->links() }}</div>
        </div>
    </div>

    <!-- Confirm Delete Modal (shared) - improved layout -->
    <div id="confirm-delete-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
        <div class="fixed inset-0 flex min-h-full items-end sm:items-center justify-center p-4 sm:p-6">
            <div id="confirm-panel" class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 ring-1 ring-gray-200">
                <div class="px-6 pt-6">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v4m0 4h.01M4.93 4.93a10 10 0 1114.14 14.14A10 10 0 014.93 4.93z" />
                        </svg>
                    </div>
                    <h3 id="confirm-title" class="mt-4 text-lg font-semibold text-gray-900">{{ __('Hapus permintaan?') }}</h3>
                    <p id="confirm-message" class="mt-2 text-sm leading-relaxed text-gray-600">{{ __('Tindakan ini tidak dapat dibatalkan. Data akan dihapus permanen.') }}</p>
                </div>
                <div class="mt-6 flex items-center justify-end gap-3 border-t border-gray-100 px-6 py-4 bg-gray-50">
                    <button type="button" id="confirm-cancel" class="inline-flex justify-center rounded-full border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">{{ __('Batal') }}</button>
                    <button type="button" id="confirm-submit" class="inline-flex justify-center rounded-full bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600">{{ __('Hapus') }}</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('confirm-delete-modal');
            const panel = document.getElementById('confirm-panel');
            const title = document.getElementById('confirm-title');
            const message = document.getElementById('confirm-message');
            const btnCancel = document.getElementById('confirm-cancel');
            const btnSubmit = document.getElementById('confirm-submit');
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
