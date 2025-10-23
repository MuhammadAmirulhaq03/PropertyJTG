@once
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            if (!csrfMeta) {
                return;
            }

            const csrfToken = csrfMeta.getAttribute('content');
            const activeClasses = ['bg-[#DB4437]', 'text-white'];
            const inactiveClasses = ['bg-white/90', 'text-[#DB4437]'];

            const updateButtonState = (button, favorited) => {
                button.dataset.favorited = favorited ? 'true' : 'false';
                button.setAttribute('aria-pressed', favorited ? 'true' : 'false');

                activeClasses.forEach((cls) => button.classList.toggle(cls, favorited));
                inactiveClasses.forEach((cls) => button.classList.toggle(cls, !favorited));

                if (button.dataset.labelActive && button.dataset.labelInactive) {
                    button.setAttribute('title', favorited ? button.dataset.labelActive : button.dataset.labelInactive);
                }

                const svg = button.querySelector('svg');
                if (svg) {
                    svg.setAttribute('fill', favorited ? 'currentColor' : 'none');
                }
            };

            const refreshEmptyState = () => {
                const grid = document.querySelector('[data-favorites-grid]');
                const emptyState = document.querySelector('[data-favorites-empty]');

                if (!grid || !emptyState) {
                    return;
                }

                const hasCards = Boolean(grid.querySelector('[data-favorite-card]'));
                emptyState.classList.toggle('hidden', hasCards);
            };

            const handleResponse = async (response) => {
                if (response.redirected) {
                    window.location.href = response.url;
                    return null;
                }

                let payload = {};
                try {
                    payload = await response.clone().json();
                } catch (error) {
                    // Ignore JSON parse errors
                }

                if (!response.ok) {
                    const message = payload?.message || '{{ __('Terjadi kesalahan. Silakan coba lagi.') }}';
                    alert(message);
                    return null;
                }

                return payload;
            };

            const dispatchUpdate = (propertyId, favorited, sourceButton) => {
                window.dispatchEvent(new CustomEvent('favorites:updated', {
                    detail: {
                        propertyId: String(propertyId),
                        favorited,
                        source: sourceButton,
                    },
                }));
            };

            const submitToggle = async (button) => {
                if (!button || button.disabled) {
                    return;
                }

                const propertyId = button.dataset.propertyId;
                const isFavorited = button.dataset.favorited === 'true';
                const targetUrl = isFavorited ? button.dataset.destroyUrl : button.dataset.storeUrl;
                const method = isFavorited ? 'DELETE' : 'POST';

                if (!targetUrl) {
                    return;
                }

                button.disabled = true;

                try {
                    const response = await fetch(targetUrl, {
                        method,
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });

                    const payload = await handleResponse(response);
                    if (!payload) {
                        return;
                    }

                    const nextState = !isFavorited;
                    updateButtonState(button, nextState);
                    button.blur();

                    if (button.dataset.removeOnUnfavorite === 'true' && !nextState) {
                        const card = button.closest('[data-favorite-card]');
                        if (card) {
                            card.classList.add('opacity-0', 'transition', 'duration-200');
                            setTimeout(() => {
                                card.remove();
                                refreshEmptyState();
                            }, 180);
                        }
                    }

                    dispatchUpdate(propertyId, nextState, button);
                } catch (error) {
                    alert('{{ __('Tidak dapat terhubung ke server. Silakan coba lagi.') }}');
                } finally {
                    button.disabled = false;
                }
            };

            document.querySelectorAll('.js-favorite-toggle').forEach((button) => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    submitToggle(button);
                });
            });

            window.addEventListener('favorites:updated', (event) => {
                const { propertyId, favorited, source } = event.detail || {};
                if (!propertyId) {
                    return;
                }

                document.querySelectorAll(`.js-favorite-toggle[data-property-id="${propertyId}"]`).forEach((button) => {
                    if (source && button === source) {
                        return;
                    }
                    updateButtonState(button, Boolean(favorited));
                });

                refreshEmptyState();
            });

            refreshEmptyState();
        });
    </script>
@endonce
