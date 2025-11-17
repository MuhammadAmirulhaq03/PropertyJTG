@php
    use Illuminate\Support\Str;
    $isEdit = $property->exists;
@endphp

<form method="POST" action="{{ $formAction }}" enctype="multipart/form-data" class="space-y-10">
    @csrf
    @isset($formMethod)
        @method($formMethod)
    @endisset

    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <section class="grid gap-6 lg:grid-cols-[minmax(0,3fr)_minmax(0,2fr)]">
        <article class="space-y-8 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
            <header class="space-y-1">
                <h2 class="text-lg font-semibold text-gray-900">{{ __('Detail Properti') }}</h2>
                <p class="text-sm text-gray-500">
                    {{ __('Lengkapi informasi utama yang akan tampil di listing utama.') }}
                </p>
            </header>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="nama" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Nama Properti') }}</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $property->nama) }}" required
                           class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                </div>
                <div>
                    <label for="lokasi" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Lokasi') }}</label>
                    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $property->lokasi) }}" required
                           class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-3">
                <div>
                    <label for="harga" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Harga (IDR)') }}</label>
                    <input type="number" min="0" step="1000000" id="harga" name="harga" value="{{ old('harga', $property->harga) }}" required
                           class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                    <p class="mt-1 text-xs text-gray-400">{{ __('Tuliskan tanpa tanda baca. Contoh: 1250000000') }}</p>
                </div>
                <div>
                    <label for="units_available" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Unit Tersedia') }}</label>
                    <input type="number" min="0" id="units_available" name="units_available" value="{{ old('units_available', $property->units_available) }}"
                           class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                    <p class="mt-1 text-xs text-gray-400">{{ __('Opsional. Kosongkan jika tidak ingin menampilkan stok unit.') }}</p>
                </div>
                <div>
                    <label for="tipe" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Segmentasi Listing') }}</label>
                    <select id="tipe" name="tipe" required
                            class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                        @foreach($segments as $key => $label)
                            <option value="{{ $key }}" @selected(old('tipe', $property->tipe) === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Status') }}</label>
                    <select id="status" name="status" required
                            class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" @selected(old('status', $property->status) === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="tipe_properti" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Kategori Properti') }}</label>
                    <select id="tipe_properti" name="tipe_properti" required
                            class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                        @foreach($types as $key => $label)
                            <option value="{{ $key }}" @selected(old('tipe_properti', $property->tipe_properti) === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="spesifikasi" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Spesifikasi Teknis') }}</label>
                    <textarea id="spesifikasi" name="spesifikasi" rows="4"
                              class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]"
                              placeholder="{{ __('Contoh: Luas bangunan, luas tanah, jumlah kamar, listrik, air, fasilitas tambahan.') }}">{{ old('spesifikasi', $property->spesifikasi) }}</textarea>
                </div>
            </div>

            <div>
                <label for="deskripsi" class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Deskripsi Properti') }}</label>
                <textarea id="deskripsi" name="deskripsi" rows="5"
                          class="mt-1 w-full rounded-2xl border border-gray-200 bg-gray-50 text-sm focus:border-[#2563EB] focus:ring-[#2563EB]"
                          placeholder="{{ __('Ceritakan highlight properti, keunggulan lokasi, akses transportasi, atau konsep desain.') }}">{{ old('deskripsi', $property->deskripsi) }}</textarea>
            </div>
        </article>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-[#2563EB]/20 bg-[#2563EB]/5 p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-[#1D4ED8]">{{ __('Panduan Unggah Media') }}</h2>
                <ul class="mt-4 space-y-3 text-sm text-[#1D4ED8]/80">
                    @foreach($guidelines as $guide)
                        <li class="flex items-start gap-3">
                            <span class="mt-1 inline-flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-white text-xs font-semibold text-[#2563EB] shadow">
                                {{ $loop->iteration }}
                            </span>
                            <span>{{ $guide }}</span>
                        </li>
                    @endforeach
                </ul>
                <p class="mt-4 text-xs text-[#1D4ED8]/60">
                    {{ __('Maksimal :limit file media per properti. File baru dapat dipilih secara bertahap menggunakan tombol penambah baris.', ['limit' => $mediaLimit]) }}
                </p>
            </div>

            <div class="space-y-4 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <header>
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('Galeri Media') }}</h2>
                    <p class="text-sm text-gray-500">
                        {{ __('Kelola urutan, caption, dan media unggulan yang tampil di halaman utama.') }}
                    </p>
                </header>

                @if($isEdit && $property->media->isNotEmpty())
                    <div class="space-y-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gray-400">{{ __('Media yang Sudah Ada') }}</p>
                        <div class="space-y-6">
                            @foreach($property->media as $media)
                                <div class="rounded-2xl border border-gray-200 bg-gray-50/80 p-4">
                                    <div class="flex flex-col gap-4 md:flex-row md:items-start">
                                        <div class="w-full md:w-40">
                                            @if($media->media_type === 'image')
                                                <img src="{{ $media->url }}" alt="{{ $media->caption ?? $property->nama }}"
                                                     class="h-28 w-full rounded-2xl object-cover">
                                            @else
                                                <video controls class="h-28 w-full rounded-2xl object-cover">
                                                    <source src="{{ $media->url }}">
                                                </video>
                                            @endif
                                        </div>
                                        <div class="flex-1 space-y-3">
                                            <div class="flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-widest text-gray-400">
                                                <label class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1 text-[11px] font-semibold text-gray-600">
                                                    <input type="radio" name="featured_media" value="existing:{{ $media->id }}" class="rounded-full text-[#2563EB]"
                                                        @checked(old('featured_media', $media->is_primary ? 'existing:'.$media->id : null) === 'existing:'.$media->id)>
                                                    {{ __('Jadikan Media Utama') }}
                                                </label>
                                                <label class="inline-flex items-center gap-2 rounded-full border border-red-200 px-3 py-1 text-[11px] font-semibold text-red-600">
                                                    <input type="checkbox" name="remove_media[]" value="{{ $media->id }}" class="rounded text-red-500">
                                                    {{ __('Hapus media ini') }}
                                                </label>
                                            </div>
                                            <div class="grid gap-3 sm:grid-cols-[minmax(0,1fr)_120px]">
                                                <div>
                                                    <label class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Caption') }}</label>
                                                    <input type="text" name="existing_media[{{ $media->id }}][caption]"
                                                           value="{{ old("existing_media.{$media->id}.caption", $media->caption) }}"
                                                           class="mt-1 w-full rounded-2xl border border-gray-200 bg-white text-sm focus:border-[#2563EB] focus:ring-[#2563EB]"
                                                           placeholder="{{ __('Contoh: Living room utama, dapur, view balkon, dll.') }}">
                                                </div>
                                                <div>
                                                    <label class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Urutan') }}</label>
                                                    <input type="number" min="0" name="existing_media[{{ $media->id }}][sort_order]"
                                                           value="{{ old("existing_media.{$media->id}.sort_order", $media->sort_order) }}"
                                                           class="mt-1 w-full rounded-2xl border border-gray-200 bg-white text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="space-y-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-gray-400">{{ __('Tambah Media Baru') }}</p>
                    <div id="media-upload-rows" data-max-rows="{{ $mediaLimit }}" class="space-y-4">
                        <div class="media-upload-row flex flex-col gap-3 rounded-2xl border border-dashed border-gray-300 bg-gray-50/70 p-4">
                            <div class="flex flex-col gap-3 md:flex-row md:items-center">
                                <label class="md:w-40 text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('File Media') }}</label>
                                <input type="file" name="media[]" accept="image/*,video/*"
                                       class="w-full rounded-2xl border border-gray-200 bg-white text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                            </div>
                            <div class="flex flex-col gap-3 md:flex-row md:items-center">
                                <label class="md:w-40 text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Caption (opsional)') }}</label>
                                <input type="text" name="media_caption[]" placeholder="{{ __('Berikan konteks singkat untuk media ini.') }}"
                                       class="w-full rounded-2xl border border-gray-200 bg-white text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                            </div>
                            <div class="flex flex-col gap-3 md:flex-row md:items-center">
                                <label class="md:w-40 text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Media Utama?') }}</label>
                                <label class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-semibold text-gray-600">
                                    <input type="radio" name="featured_media" value="new:0" class="rounded-full text-[#2563EB]">
                                    {{ __('Pilih baris ini sebagai unggulan') }}
                                </label>
                            </div>
                            <button type="button" class="remove-media-row inline-flex items-center gap-2 self-end rounded-full border border-red-200 px-3 py-1 text-xs font-semibold text-red-600 transition hover:border-red-300 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ __('Hapus baris') }}
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" id="add-media-row"
                                class="inline-flex items-center gap-2 rounded-full border border-[#2563EB] px-4 py-2 text-xs font-semibold text-[#2563EB] transition hover:bg-[#2563EB]/5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m6-6H6" />
                            </svg>
                            {{ __('Tambah Baris Media') }}
                        </button>
                        <span class="text-xs text-gray-400">
                            {{ __('Maksimal :limit file, saat melewati batas baris tambahan akan dinonaktifkan.', ['limit' => $mediaLimit]) }}
                        </span>
                    </div>
                </div>
            </div>
        </aside>
    </section>

    <div class="flex flex-wrap items-center justify-end gap-3">
        <a href="{{ route('admin.properties.index') }}"
           class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 transition hover:border-gray-300 hover:text-gray-900">
            {{ __('Batal') }}
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-full bg-[#2563EB] px-6 py-2 text-sm font-semibold text-white transition hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12l5 5L19 7" />
            </svg>
            {{ $isEdit ? __('Simpan Perubahan') : __('Simpan Properti') }}
        </button>
    </div>
</form>

<script>
    (function () {
        const container = document.getElementById('media-upload-rows');
        if (!container) {
            return;
        }

        const addButton = document.getElementById('add-media-row');
        const maxRows = Number(container.dataset.maxRows || 12);

        const template = (index) => {
            return `
                <div class="media-upload-row flex flex-col gap-3 rounded-2xl border border-dashed border-gray-300 bg-gray-50/70 p-4">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center">
                        <label class="md:w-40 text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('File Media') }}</label>
                        <input type="file" name="media[]" accept="image/*,video/*"
                               class="w-full rounded-2xl border border-gray-200 bg-white text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                    </div>
                    <div class="flex flex-col gap-3 md:flex-row md:items-center">
                        <label class="md:w-40 text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Caption (opsional)') }}</label>
                        <input type="text" name="media_caption[]" placeholder="{{ __('Berikan konteks singkat untuk media ini.') }}"
                               class="w-full rounded-2xl border border-gray-200 bg-white text-sm focus:border-[#2563EB] focus:ring-[#2563EB]">
                    </div>
                    <div class="flex flex-col gap-3 md:flex-row md:items-center">
                        <label class="md:w-40 text-xs font-semibold uppercase tracking-widest text-gray-500">{{ __('Media Utama?') }}</label>
                        <label class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-semibold text-gray-600">
                            <input type="radio" name="featured_media" value="new:${index}" class="rounded-full text-[#2563EB]">
                            {{ __('Pilih baris ini sebagai unggulan') }}
                        </label>
                    </div>
                    <button type="button" class="remove-media-row inline-flex items-center gap-2 self-end rounded-full border border-red-200 px-3 py-1 text-xs font-semibold text-red-600 transition hover:border-red-300 hover:text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        {{ __('Hapus baris') }}
                    </button>
                </div>
            `;
        };

        const refreshControls = () => {
            const rows = container.querySelectorAll('.media-upload-row');
            if (rows.length >= maxRows) {
                addButton.setAttribute('disabled', 'disabled');
                addButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                addButton.removeAttribute('disabled');
                addButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }

            rows.forEach((row, index) => {
                const featured = row.querySelector('input[type="radio"][name="featured_media"]');
                if (featured) {
                    featured.value = `new:${index}`;
                }
            });
        };

        const handleRemove = (button) => {
            button.closest('.media-upload-row')?.remove();
            refreshControls();
        };

        container.addEventListener('click', (event) => {
            if (!(event.target instanceof Element)) return;
            const removeBtn = event.target.closest('.remove-media-row');
            if (removeBtn) {
                event.preventDefault();
                handleRemove(removeBtn);
            }
        });

        addButton?.addEventListener('click', (event) => {
            event.preventDefault();
            const nextIndex = container.querySelectorAll('.media-upload-row').length;
            if (nextIndex >= maxRows) {
                return;
            }
            container.insertAdjacentHTML('beforeend', template(nextIndex));
            refreshControls();
        });

        refreshControls();
    })();
</script>
