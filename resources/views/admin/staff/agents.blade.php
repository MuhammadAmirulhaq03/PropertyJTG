<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#2563EB]">{{ __('Staff Management') }}</p>
            <h1 class="text-2xl font-bold text-gray-900 md:text-3xl">{{ __('Agen') }}</h1>
            <p class="text-sm text-gray-500">{{ __('Buat akun agen baru (email wajib gmail.com) dan reset kata sandi bila diperlukan.') }}</p>
        </div>
    </x-slot>

    <div class="space-y-8">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
        @endif

        <!-- Info banner -->
        <div class="rounded-3xl border border-blue-200 bg-blue-50 p-5 text-sm text-blue-800 flex items-start gap-3">
            <div class="mt-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm9.75-4.5a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5ZM12 10.5a.75.75 0 0 0-.75.75v5.25a.75.75 0 0 0 1.5 0V11.25A.75.75 0 0 0 12 10.5Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <p class="font-semibold">{{ __('Kebijakan akun agen') }}</p>
                <p class="mt-1 text-blue-900/80">{{ __('Email harus menggunakan domain gmail.com. Agen wajib mengganti password pada login pertama (status: Pending password change).') }}</p>
            </div>
        </div>

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">{{ __('Buat Agen Baru') }}</h2>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12h18M3 12l6-6m-6 6l6 6" />
                    </svg>
                    {{ __('Kembali ke Dashboard') }}
                </a>
            </div>
            <form method="POST" action="{{ route('admin.staff.agents.store') }}" class="mt-4 grid gap-4 md:grid-cols-2">
                @csrf
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 100-10 5 5 0 000 10z"/><path fill-rule="evenodd" d="M.75 21a11.25 11.25 0 1122.5 0H.75z" clip-rule="evenodd"/></svg>
                        Nama
                    </label>
                    <input name="name" value="{{ old('name') }}" class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]" required />
                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M1.5 6.75A2.25 2.25 0 013.75 4.5h16.5A2.25 2.25 0 0122.5 6.75v10.5A2.25 2.25 0 0120.25 19.5H3.75A2.25 2.25 0 011.5 17.25V6.75z"/><path d="M3 7.5l9 6 9-6"/></svg>
                        Email (gmail.com)
                    </label>
                    <input name="email" type="email" value="{{ old('email') }}" class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]" required />
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M2.25 5.25A2.25 2.25 0 014.5 3h3.879a2.25 2.25 0 011.59.659l2.122 2.122A2.25 2.25 0 0014.68 6.5h4.82a2.25 2.25 0 012.25 2.25v8.25A2.25 2.25 0 0119.5 19H4.5A2.25 2.25 0 012.25 16.75V5.25z"/></svg>
                        Telepon
                    </label>
                    <input name="phone" value="{{ old('phone') }}" class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]" />
                    @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div></div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1.5a5.25 5.25 0 00-5.25 5.25v2.25H5.25A2.25 2.25 0 003 11.25v7.5A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75v-7.5A2.25 2.25 0 0018.75 9H17.25V6.75A5.25 5.25 0 0012 1.5zM8.25 9V6.75a3.75 3.75 0 117.5 0V9h-7.5z"/></svg>
                        Password Sementara
                    </label>
                    <input name="password" type="password" class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]" required />
                    @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1.5a5.25 5.25 0 00-5.25 5.25v2.25H5.25A2.25 2.25 0 003 11.25v7.5A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75v-7.5A2.25 2.25 0 0018.75 9H17.25V6.75A5.25 5.25 0 0012 1.5zM8.25 9V6.75a3.75 3.75 0 117.5 0V9h-7.5z"/></svg>
                        Konfirmasi Password
                    </label>
                    <input name="password_confirmation" type="password" class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]" required />
                </div>
                <div class="md:col-span-2">
                    <button class="inline-flex items-center gap-2 rounded-full bg-[#DB4437] px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#c63c31]">
                        {{ __('Buat Akun') }}
                    </button>
                </div>
            </form>
        </section>

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <h2 class="text-lg font-semibold text-gray-900">{{ __('Daftar Agen') }}</h2>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input id="agent-filter" type="text" placeholder="{{ __('Cari nama atau email...') }}" class="w-64 rounded-full border-gray-200 bg-gray-50 pl-9 pr-3 py-2 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]" />
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/></svg>
                    </div>
                </div>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Nama</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Email</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Telepon</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Status</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Terakhir Aktif</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($agents as $agent)
                            <tr class="agent-row">
                                <td class="px-4 py-2 font-semibold text-gray-900">{{ $agent->display_name }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ $agent->email }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ $agent->phone ?: '-' }}</td>
                                <td class="px-4 py-2">
                                    @php $pending = (bool) ($agent->must_change_password ?? false); @endphp
                                    @if ($pending)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700">
                                            <span class="inline-block h-1.5 w-1.5 rounded-full bg-amber-600"></span>
                                            {{ __('Pending password change') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">
                                            <span class="inline-block h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                                            {{ __('Active') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-gray-700">{{ optional($agent->last_seen_at)->diffForHumans() ?: '—' }}</td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <form id="reset-agent-{{ $agent->id }}" method="POST" action="{{ route('admin.staff.agents.reset', $agent) }}" class="inline-flex">
                                        @csrf
                                        <button type="button" data-confirm-form="reset-agent-{{ $agent->id }}" data-confirm-title="{{ __('Reset Kata Sandi?') }}" data-confirm-message="{{ __('Atur password sementara dan paksa ganti saat login berikutnya.') }}" class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-white px-4 py-1 text-xs font-semibold text-red-600 transition hover:border-red-300 hover:bg-red-50 hover:text-red-700">
                                            {{ __('Reset Password') }}
                                        </button>
                                    </form>
                                    <form id="delete-agent-{{ $agent->id }}" method="POST" action="{{ route('admin.staff.agents.destroy', $agent) }}" class="inline-flex ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-confirm-form="delete-agent-{{ $agent->id }}" data-confirm-title="{{ __('Hapus Agen?') }}" data-confirm-message="{{ __('Tindakan ini akan menghapus akun agen beserta data terkait. Tindakan tidak dapat dibatalkan.') }}" class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-1 text-xs font-semibold text-gray-700 transition hover:border-gray-300 hover:bg-gray-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 7h12m-9 0l1-2h4l1 2m-8 0l1 12a2 2 0 002 2h4a2 2 0 002-2l1-12" />
                                            </svg>
                                            {{ __('Hapus') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">{{ __('Belum ada agen.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Shared red confirm modal -->
        <div id="confirm-staff-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
            <div class="fixed inset-0 flex min-h-full items-end sm:items-center justify-center p-4 sm:p-6">
                <div id="confirm-staff-panel" class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 ring-1 ring-red-200">
                    <div class="px-6 pt-6">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v4m0 4h.01M4.93 4.93a10 10 0 1114.14 14.14A10 10 0 014.93 4.93z" />
                            </svg>
                        </div>
                        <h3 id="confirm-staff-title" class="mt-4 text-lg font-semibold text-gray-900">{{ __('Konfirmasi') }}</h3>
                        <p id="confirm-staff-message" class="mt-2 text-sm leading-relaxed text-gray-600">{{ __('Tindakan ini akan mengatur ulang kata sandi.') }}</p>
                    </div>
                    <div class="mt-6 flex items-center justify-end gap-3 border-t border-gray-100 px-6 py-4 bg-gray-50">
                        <button type="button" id="confirm-staff-cancel" class="inline-flex justify-center rounded-full border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">{{ __('Batal') }}</button>
                        <button type="button" id="confirm-staff-submit" class="inline-flex justify-center rounded-full bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600">{{ __('Lanjutkan') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            (function () {
                const modal = document.getElementById('confirm-staff-modal');
                const panel = document.getElementById('confirm-staff-panel');
                const title = document.getElementById('confirm-staff-title');
                const message = document.getElementById('confirm-staff-message');
                const btnCancel = document.getElementById('confirm-staff-cancel');
                const btnSubmit = document.getElementById('confirm-staff-submit');
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

            // Lightweight client-side filter for agents (by name/email)
            (function () {
                const input = document.getElementById('agent-filter');
                if (!input) return;
                const rows = Array.from(document.querySelectorAll('tbody .agent-row'));
                input.addEventListener('input', function () {
                    const q = this.value.toLowerCase().trim();
                    rows.forEach(row => {
                        const t = row.textContent.toLowerCase();
                        row.style.display = q && !t.includes(q) ? 'none' : '';
                    });
                });
            })();
        </script>
    </div>
</x-admin.layouts.app>
