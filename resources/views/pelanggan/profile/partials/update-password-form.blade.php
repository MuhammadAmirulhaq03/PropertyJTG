<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <!-- Updated form tag -->
    <form id="password-update-form" method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>

    <!-- Confirm Password Change Modal (red theme) -->
    <div
        id="confirm-password-change-modal"
        class="fixed inset-0 z-50 hidden"
        aria-hidden="true"
        role="dialog"
        aria-modal="true"
    >
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

        <div class="fixed inset-0 flex min-h-full items-end sm:items-center justify-center p-4 sm:p-6">
            <div
                id="confirm-password-panel"
                class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 ring-1 ring-red-200"
            >
                <div class="px-6 pt-6">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-red-600"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M12 9v4m0 4h.01M4.93 4.93a10 10 0 1114.14 14.14A10 10 0 014.93 4.93z"
                            />
                        </svg>
                    </div>

                    <h3 class="mt-4 text-lg font-semibold text-gray-900">
                        Konfirmasi Perubahan Kata Sandi
                    </h3>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600">
                        Anda yakin ingin mengubah kata sandi akun Anda?
                    </p>
                </div>

                <div
                    class="mt-6 flex items-center justify-end gap-3 border-t border-gray-100 px-6 py-4 bg-gray-50"
                >
                    <button
                        type="button"
                        id="confirm-password-cancel"
                        class="inline-flex justify-center rounded-full border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300"
                    >
                        Batal
                    </button>

                    <button
                        type="button"
                        id="confirm-password-submit"
                        class="inline-flex justify-center rounded-full bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600"
                    >
                        Ubah Kata Sandi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const form = document.getElementById('password-update-form');
            if (!form) return;

            const newPw = document.getElementById('update_password_password');
            const modal = document.getElementById('confirm-password-change-modal');
            const panel = document.getElementById('confirm-password-panel');
            const btnCancel = document.getElementById('confirm-password-cancel');
            const btnSubmit = document.getElementById('confirm-password-submit');
            let confirmed = false;

            function openModal() {
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
                }, 150);
            }

            form.addEventListener('submit', function (e) {
                if (confirmed) return;

                const next = (newPw?.value || '').trim();
                if (next.length > 0) {
                    e.preventDefault();
                    openModal();
                }
            });

            btnCancel?.addEventListener('click', closeModal);

            modal?.addEventListener('click', function (e) {
                if (e.target === modal) closeModal();
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
            });

            btnSubmit?.addEventListener('click', function () {
                confirmed = true;
                if (typeof form.requestSubmit === 'function') {
                    form.requestSubmit();
                } else {
                    form.submit();
                }
                closeModal();
            });
        })();
    </script>
</section>
