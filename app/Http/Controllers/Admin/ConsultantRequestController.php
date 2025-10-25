<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ConsultantRequestController extends Controller
{
    public function index(Request $request): View
    {
        $filters = [
            'search' => trim((string) $request->input('search', '')),
            'date_from' => $request->input('date_from', ''),
            'date_to' => $request->input('date_to', ''),
        ];

        $query = Consultant::query();

        if ($filters['search'] !== '') {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('nama', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%")
                    ->orWhere('spesialisasi', 'like', "%{$term}%")
                    ->orWhere('alamat', 'like', "%{$term}%");
            });
        }

        if ($filters['date_from'] !== '') {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if ($filters['date_to'] !== '') {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        $requests = $query->orderByDesc('created_at')->paginate(12)->withQueryString();

        $stats = [
            'total' => Consultant::count(),
            'filtered' => (clone $query)->count(),
        ];

        return view('admin.requests.consultants', [
            'items' => $requests,
            'filters' => $filters,
            'stats' => $stats,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $filters = [
            'search' => trim((string) $request->input('search', '')),
            'date_from' => $request->input('date_from', ''),
            'date_to' => $request->input('date_to', ''),
        ];

        $query = Consultant::query();

        if ($filters['search'] !== '') {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('nama', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%")
                    ->orWhere('spesialisasi', 'like', "%{$term}%")
                    ->orWhere('alamat', 'like', "%{$term}%");
            });
        }

        if ($filters['date_from'] !== '') {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if ($filters['date_to'] !== '') {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        $filename = 'consultant-requests-' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [__('Tanggal'), __('Nama'), __('Email'), __('Telepon'), __('Alamat'), __('Spesialisasi')]);
            $query->orderByDesc('created_at')->chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        optional($row->created_at)->format('Y-m-d H:i:s'),
                        $row->nama,
                        $row->email,
                        $row->phone,
                        $row->alamat,
                        $row->spesialisasi,
                    ]);
                }
            });
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function destroy(Consultant $consultant): RedirectResponse
    {
        $consultant->delete();

        return back()->with('success', __('Permintaan konsultasi dihapus.'));
    }
}

