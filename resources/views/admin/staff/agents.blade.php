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

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">{{ __('Buat Agen Baru') }}</h2>
            <form method="POST" action="{{ route('admin.staff.agents.store') }}" class="mt-4 grid gap-4 md:grid-cols-2">
                @csrf
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">Nama</label>
                    <input name="name" value="{{ old('name') }}" class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]" required />
                    @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">Email (gmail.com)</label>
                    <input name="email" type="email" value="{{ old('email') }}" class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]" required />
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">Telepon</label>
                    <input name="phone" value="{{ old('phone') }}" class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]" />
                    @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div></div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">Password Sementara</label>
                    <input name="password" type="password" class="mt-1 w-full rounded-2xl border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]" required />
                    @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">Konfirmasi Password</label>
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
            <h2 class="text-lg font-semibold text-gray-900">{{ __('Daftar Agen') }}</h2>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Nama</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Email</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Telepon</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($agents as $agent)
                            <tr>
                                <td class="px-4 py-2 font-semibold text-gray-900">{{ $agent->name }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ $agent->email }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ $agent->phone ?: '-' }}</td>
                                <td class="px-4 py-2">
                                    <form id="reset-agent-{{ $agent->id }}" method="POST" action="{{ route('admin.staff.agents.reset', $agent) }}" class="inline-flex">
                                        @csrf
                                        <button type="button" data-confirm-form="reset-agent-{{ $agent->id }}" data-confirm-title="{{ __('Reset Kata Sandi?') }}" data-confirm-message="{{ __('Atur password sementara dan paksa ganti saat login berikutnya.') }}" class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-white px-4 py-1 text-xs font-semibold text-red-600 transition hover:border-red-300 hover:bg-red-50 hover:text-red-700">
                                            {{ __('Reset Password') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">{{ __('Belum ada agen.') }}</td></tr>
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
        </script>
    </div>
</x-admin.layouts.app>

