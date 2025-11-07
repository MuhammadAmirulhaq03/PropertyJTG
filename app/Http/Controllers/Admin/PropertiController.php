<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Properti;
use App\Models\PropertiMedia;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\View\View;

class PropertiController extends Controller
{
    private const PROPERTY_TYPES = [
        'residensial' => 'Residensial',
        'komersial' => 'Komersial',
        'apartemen' => 'Apartemen',
        'tanah' => 'Tanah Kosong',
        'lainnya' => 'Lainnya',
    ];

    private const PROPERTY_SEGMENTS = [
        'primary' => 'Primary',
        'secondary' => 'Secondary',
        'premium' => 'Premium',
    ];

    private const PROPERTY_STATUS = [
        'draft' => 'Draft',
        'published' => 'Dipublikasikan',
        'archived' => 'Diarsipkan',
    ];

    private const MAX_MEDIA_UPLOADS = 12;

    public function index(Request $request): View
    {
        $filters = [
            'search' => trim((string) $request->input('search')),
            'status' => $request->input('status', 'all'),
            'type' => $request->input('type', 'all'),
        ];

        $propertiesQuery = Properti::query()
            ->with(['primaryMedia', 'media' => fn ($query) => $query->orderBy('is_primary', 'desc')->orderBy('sort_order')])
            ->when($filters['search'], function (Builder $query) use ($filters) {
                $query->where(function (Builder $searchQuery) use ($filters) {
                    $searchQuery
                        ->where('nama', 'like', "%{$filters['search']}%")
                        ->orWhere('lokasi', 'like', "%{$filters['search']}%")
                        ->orWhere('tipe', 'like', "%{$filters['search']}%");
                });
            })
            ->when($filters['status'] !== 'all', fn (Builder $query) => $query->where('status', $filters['status']))
            ->when($filters['type'] !== 'all', fn (Builder $query) => $query->where('tipe_properti', $filters['type']))
            ->orderByDesc('created_at');

        $properties = $propertiesQuery->paginate(8)->withQueryString();

        $stats = [
            'total' => Properti::count(),
            'published' => Properti::where('status', 'published')->count(),
            'drafts' => Properti::where('status', 'draft')->count(),
            'archived' => Properti::where('status', 'archived')->count(),
        ];

        return view('admin.properti.index', [
            'properties' => $properties,
            'filters' => $filters,
            'stats' => $stats,
            'types' => self::PROPERTY_TYPES,
            'segments' => self::PROPERTY_SEGMENTS,
            'statuses' => self::PROPERTY_STATUS,
            'mediaLimit' => self::MAX_MEDIA_UPLOADS,
            'guidelines' => $this->mediaGuidelines(),
        ]);
    }

    public function create(): View
    {
        return view('admin.properti.create', [
            'property' => new Properti(),
            'types' => self::PROPERTY_TYPES,
            'segments' => self::PROPERTY_SEGMENTS,
            'statuses' => self::PROPERTY_STATUS,
            'mediaLimit' => self::MAX_MEDIA_UPLOADS,
            'guidelines' => $this->mediaGuidelines(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProperty($request);

        $admin = Admin::firstOrCreate(['user_id' => $request->user()->id]);

        $property = DB::transaction(function () use ($validated, $request, $admin) {
            /** @var Properti $property */
            $property = Properti::create([
                'nama' => $validated['nama'],
                'lokasi' => $validated['lokasi'],
                'harga' => $validated['harga'],
                'tipe' => $validated['tipe'],
                'status' => $validated['status'],
                'spesifikasi' => $validated['spesifikasi'],
                'deskripsi' => $validated['deskripsi'],
                'tipe_properti' => $validated['tipe_properti'],
                'admin_id' => $admin->id,
            ]);

            $this->syncMedia($request, $property, $validated['featured_media'] ?? null);

            return $property;
        });

        return redirect()
            ->route('admin.properties.index')
            ->with('success', __('Properti berhasil disimpan dan siap dikelola di Smart Listing.'));
    }

    public function edit(Properti $property): View
    {
        $property->load('media');

        return view('admin.properti.edit', [
            'property' => $property,
            'types' => self::PROPERTY_TYPES,
            'segments' => self::PROPERTY_SEGMENTS,
            'statuses' => self::PROPERTY_STATUS,
            'mediaLimit' => self::MAX_MEDIA_UPLOADS,
            'guidelines' => $this->mediaGuidelines(),
        ]);
    }

    public function update(Request $request, Properti $property): RedirectResponse
    {
        $validated = $this->validateProperty($request, $property->id);

        DB::transaction(function () use ($validated, $request, $property) {
            $property->update([
                'nama' => $validated['nama'],
                'lokasi' => $validated['lokasi'],
                'harga' => $validated['harga'],
                'tipe' => $validated['tipe'],
                'status' => $validated['status'],
                'spesifikasi' => $validated['spesifikasi'],
                'deskripsi' => $validated['deskripsi'],
                'tipe_properti' => $validated['tipe_properti'],
            ]);

            $this->syncMedia($request, $property, $validated['featured_media'] ?? null);
        });

        return redirect()
            ->route('admin.properties.index')
            ->with('success', __('Perubahan properti berhasil disimpan.'));
    }

    public function destroy(Properti $property): RedirectResponse
    {
        $property->delete();

        return redirect()
            ->route('admin.properties.index')
            ->with('success', __('Properti berhasil dihapus.'));
    }

    public function bulkStatus(Request $request): RedirectResponse
    {
        $admin = Admin::firstOrCreate(['user_id' => $request->user()->id]);

        $validated = $request->validate([
            'property_ids' => ['required', 'array', 'min:1'],
            'property_ids.*' => [
                'integer',
                Rule::exists('propertis', 'id')->where(fn ($query) => $query->where('admin_id', $admin->id)),
            ],
            'target_status' => ['required', Rule::in(array_keys(self::PROPERTY_STATUS))],
        ]);

        $updatedCount = Properti::query()
            ->where('admin_id', $admin->id)
            ->whereIn('id', $validated['property_ids'])
            ->update(['status' => $validated['target_status']]);

        if ($updatedCount === 0) {
            return redirect()
                ->route('admin.properties.index')
                ->with('warning', __('Tidak ada properti yang diperbarui.'));
        }

        $statusLabel = $validated['target_status'] === 'published'
            ? __('dipublikasikan ke galeri')
            : ($validated['target_status'] === 'draft'
                ? __('dikembalikan ke draft')
                : __('diarsipkan'));

        return redirect()
            ->route('admin.properties.index')
            ->with('success', trans_choice(
                ':count properti berhasil :status.',
                $updatedCount,
                [
                    'count' => $updatedCount,
                    'status' => $statusLabel,
                ]
            ));
    }

    /**
     * @return array<string, mixed>
     */
    private function validateProperty(Request $request, ?int $propertyId = null): array
    {
        $existingCount = $propertyId
            ? PropertiMedia::where('properti_id', $propertyId)->count()
            : 0;
        $removeCount = collect($request->input('remove_media', []))->filter()->count();
        $availableSlots = max(self::MAX_MEDIA_UPLOADS - max(0, $existingCount - $removeCount), 0);

        $removeRule = ['integer'];
        if ($propertyId) {
            $removeRule[] = Rule::exists('properti_media', 'id')->where('properti_id', $propertyId);
        } else {
            $removeRule[] = Rule::exists('properti_media', 'id');
        }

        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:0'],
            'tipe' => ['required', Rule::in(array_keys(self::PROPERTY_SEGMENTS))],
            'status' => ['required', Rule::in(array_keys(self::PROPERTY_STATUS))],
            'tipe_properti' => ['required', Rule::in(array_keys(self::PROPERTY_TYPES))],
            'spesifikasi' => ['nullable', 'string'],
            'deskripsi' => ['nullable', 'string'],
            'featured_media' => ['nullable', 'string'],
            'existing_media' => ['sometimes', 'array'],
            'existing_media.*.caption' => ['nullable', 'string', 'max:255'],
            'existing_media.*.sort_order' => ['nullable', 'integer', 'min:0', 'max:100'],
            'remove_media' => ['sometimes', 'array'],
            'remove_media.*' => $removeRule,
            'media' => ['sometimes', 'array', 'max:' . max($availableSlots, 0)],
            'media.*' => [
                File::types([
                    'jpg',
                    'jpeg',
                    'png',
                    'webp',
                    'avif',
                    'mp4',
                    'mov',
                    'webm',
                ])->max(50 * 1024), // 50 MB
            ],
            'media_caption' => ['sometimes', 'array'],
            'media_caption.*' => ['nullable', 'string', 'max:255'],
        ]);
    }

    private function syncMedia(Request $request, Properti $property, ?string $featuredMediaInput): void
    {
        $existingMediaData = $request->input('existing_media', []);
        $mediaToRemove = collect($request->input('remove_media', []))->filter()->map(fn ($id) => (int) $id);

        $property->load('media');

        if ($mediaToRemove->isNotEmpty()) {
            $property->media()
                ->whereIn('id', $mediaToRemove)
                ->get()
                ->each(function (PropertiMedia $media) {
                    $media->delete();
                });

            $property->unsetRelation('media');
            $property->load('media');
        }

        foreach ($property->media as $media) {
            $payload = $existingMediaData[$media->id] ?? null;
            if (! $payload) {
                continue;
            }

            $media->fill([
                'caption' => Arr::get($payload, 'caption', $media->caption),
                'sort_order' => Arr::get($payload, 'sort_order', $media->sort_order ?? 0),
            ])->save();
        }

        $currentMaxOrder = (int) $property->media()->max('sort_order');
        $uploadedMediaFiles = $request->file('media', []);
        $uploadedCaptions = $request->input('media_caption', []);
        $newMediaMap = [];

        foreach ($uploadedMediaFiles as $index => $file) {
            if (! $file) {
                continue;
            }

            $mimeType = $file->getMimeType();
            $type = str_starts_with((string) $mimeType, 'image/') ? 'image' : 'video';
            $folder = $type === 'image' ? 'properties/photos' : 'properties/videos';
            $path = $file->store($folder, 'public');

            $media = $property->media()->create([
                'disk' => 'public',
                'media_path' => $path,
                'media_type' => $type,
                'caption' => $uploadedCaptions[$index] ?? null,
                'sort_order' => ++$currentMaxOrder,
                'filesize' => $file->getSize(),
            ]);

            $newMediaMap['new:' . $index] = $media->id;
        }

        $targetMediaId = null;
        if ($featuredMediaInput) {
            if (str_starts_with($featuredMediaInput, 'existing:')) {
                $targetMediaId = (int) str_replace('existing:', '', $featuredMediaInput);
            } elseif (str_starts_with($featuredMediaInput, 'new:')) {
                $targetMediaId = $newMediaMap[$featuredMediaInput] ?? null;
            }
        }

        $property->media()->update(['is_primary' => false]);

        if ($targetMediaId) {
            $property->media()->where('id', $targetMediaId)->update(['is_primary' => true]);
        } elseif ($property->media()->exists()) {
            $property->media()->orderBy('sort_order')->limit(1)->update(['is_primary' => true]);
        }
    }

    private function mediaGuidelines(): array
    {
        return [
            __('Gunakan orientasi landscape 4:3 atau 16:9 untuk foto utama.'),
            __('Resolusi minimal 1600px di sisi terpanjang, format JPG/PNG/WEBP.'),
            __('Pastikan pencahayaan cukup dan hindari watermark berlebihan.'),
            __('Isi caption untuk menjelaskan ruangan, fasilitas, atau sudut pengambilan gambar.'),
        ];
    }
}
