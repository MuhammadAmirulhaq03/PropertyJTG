<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\ConsultationSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConsultationScheduleController extends Controller
{
    /**
     * Display the consultation schedule form and list.
     */
    public function index(Request $request): View
    {
        $schedules = ConsultationSchedule::query()
            ->where('user_id', $request->user()->id)
            ->latest('tanggal')
            ->latest('waktu')
            ->get();

        return view('pelanggan.jadwal.index', [
            'schedules' => $schedules,
        ]);
    }

    /**
     * Store a new consultation schedule for the authenticated user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_konsultan' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date', 'after_or_equal:today'],
            'waktu' => ['required', 'date_format:H:i'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        ConsultationSchedule::create([
            'user_id' => $request->user()->id,
            'nama_konsultan' => $validated['nama_konsultan'],
            'tanggal' => $validated['tanggal'],
            'waktu' => $validated['waktu'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()
            ->route('pelanggan.jadwal.index')
            ->with('success', __('Jadwal konsultasi berhasil disimpan.'));
    }

    /**
     * Remove a consultation schedule owned by the authenticated user.
     */
    public function destroy(Request $request, ConsultationSchedule $schedule): RedirectResponse
    {
        $this->authorizeSchedule($schedule, $request->user()->id);

        $schedule->delete();

        return redirect()
            ->route('pelanggan.jadwal.index')
            ->with('success', __('Jadwal konsultasi dihapus.'));
    }

    /**
     * Ensure the schedule belongs to the current user.
     */
    private function authorizeSchedule(ConsultationSchedule $schedule, int $userId): void
    {
        abort_unless($schedule->user_id === $userId, 403);
    }
}
