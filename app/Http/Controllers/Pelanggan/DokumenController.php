<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DocumentUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DokumenController extends Controller
{
    private const MAX_FILE_SIZE_KB = 5120; // 5 MB
    private const STORAGE_DISK = 'local';

    public function index(Request $request)
    {
        $user = $request->user();
        $requirements = config('document-requirements', []);

        $existingUploads = DocumentUpload::query()
            ->where('user_id', $user->id)
            ->get()
            ->keyBy('document_type');

        return view('pelanggan.dokumen.index', [
            'requirements' => $requirements,
            'uploads' => $existingUploads,
            'maxFileSizeMb' => (int) ceil(self::MAX_FILE_SIZE_KB / 1024),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $requirements = config('document-requirements', []);
        $documentKeys = array_keys($requirements);
        $maxFileSizeMb = (int) ceil(self::MAX_FILE_SIZE_KB / 1024);

        $validated = $request->validate([
            'document_type' => ['required', 'string', 'in:' . implode(',', $documentKeys)],
            'document' => [
                'required',
                'file',
                'max:' . self::MAX_FILE_SIZE_KB,
                'mimetypes:application/pdf,image/jpeg',
            ],
        ], [
            'document.max' => 'Ukuran dokumen maksimal ' . $maxFileSizeMb . ' MB.',
            'document.mimetypes' => 'Dokumen harus berformat PDF atau JPG.',
        ]);

        $documentType = $validated['document_type'];
        $file = $validated['document'];

        $existing = DocumentUpload::query()
            ->where('user_id', $user->id)
            ->where('document_type', $documentType)
            ->first();

        $disk = Storage::disk(self::STORAGE_DISK);

        if ($existing && $disk->exists($existing->file_path)) {
            $disk->delete($existing->file_path);
        }

        $storedFileName = now()->format('YmdHis') . '-' . Str::random(12) . '.' . $file->getClientOriginalExtension();
        $storedPath = $file->storeAs(
            "documents/{$user->id}/{$documentType}",
            $storedFileName,
            self::STORAGE_DISK
        );

        DocumentUpload::updateOrCreate(
            [
                'user_id' => $user->id,
                'document_type' => $documentType,
            ],
            [
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $storedPath,
                'mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'status' => DocumentUpload::STATUS_SUBMITTED,
                'review_notes' => null,
            ]
        );

        return redirect()
            ->route('documents.index')
            ->with('status', $requirements[$documentType]['label'] . ' berhasil diunggah.');
    }

    public function download(Request $request, DocumentUpload $documentUpload)
    {
        $this->authorizeDownload($request, $documentUpload);

        $disk = Storage::disk(self::STORAGE_DISK);

        if (!$disk->exists($documentUpload->file_path)) {
            return redirect()
                ->route('documents.index')
                ->withErrors(['document' => 'File tidak ditemukan, harap unggah ulang.']);
        }

        return $disk->download($documentUpload->file_path, $documentUpload->original_name);
    }

    private function authorizeDownload(Request $request, DocumentUpload $documentUpload): void
    {
        abort_if(
            $documentUpload->user_id !== $request->user()->id,
            Response::HTTP_FORBIDDEN,
            'Anda tidak memiliki akses ke dokumen ini.'
        );
    }
}
