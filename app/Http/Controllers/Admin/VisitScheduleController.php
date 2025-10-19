<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VisitSchedule;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VisitScheduleController extends Controller
{
    public function index(Request $request): View
    {
        $filters = [
            'date' => $request->input('date'),
            'status' => $request->input('status', 'all'),
            'agent' => $request->input('agent_id'),
        ];

        $schedulesQuery = VisitSchedule::with(['agent', 'customer'])
            ->orderBy('start_at');

        if ($filters['date']) {
            $schedulesQuery->whereDate('start_at', $filters['date']);
        }

        if ($filters['status'] !== 'all') {
            $schedulesQuery->where('status', $filters['status']);
        }

        if ($filters['agent']) {
            $schedulesQuery->where('agent_id', $filters['agent']);
        }

        $schedules = $schedulesQuery->get();

        $stats = [
            'total' => VisitSchedule::count(),
            'upcoming' => VisitSchedule::where('start_at', '>=', now())->count(),
            'available' => VisitSchedule::where('status', 'available')->whereNull('customer_id')->count(),
            'booked' => VisitSchedule::where('status', 'booked')->count(),
            'closed' => VisitSchedule::where('status', 'closed')->count(),
        ];

        return view('admin.visit-schedules.index', [
            'selectedTab' => 'visit-schedules',
            'schedules' => $schedules,
            'stats' => $stats,
            'filters' => $filters,
            'agents' => $this->agents(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateForm($request);
        $startAt = $this->makeDateTime($data['date'], $data['start_time']);
        $endAt = $this->makeDateTime($data['date'], $data['end_time']);

        $this->ensureTimeslotIsValid($data['agent_id'], $startAt, $endAt, null);

        VisitSchedule::create([
            'agent_id' => $data['agent_id'],
            'admin_id' => $request->user()->id,
            'start_at' => $startAt,
            'end_at' => $endAt,
            'location' => $data['location'] ?? null,
            'notes' => $data['notes'] ?? null,
            'status' => 'available',
        ]);

        return redirect()
            ->route('admin.visit-schedules.index', ['tab' => 'visit-schedules'])
            ->with('success', __('Jadwal kunjungan berhasil dibuat.'));
    }

    public function edit(VisitSchedule $visitSchedule): View
    {
        return view('admin.visit-schedules.edit', [
            'selectedTab' => 'visit-schedules',
            'schedule' => $visitSchedule->load(['agent', 'customer']),
            'agents' => $this->agents(),
        ]);
    }

    public function update(Request $request, VisitSchedule $visitSchedule): RedirectResponse
    {
        $data = $this->validateForm($request);
        $startAt = $this->makeDateTime($data['date'], $data['start_time']);
        $endAt = $this->makeDateTime($data['date'], $data['end_time']);

        if ($visitSchedule->status === 'booked' && $visitSchedule->customer_id !== null && ($visitSchedule->agent_id != $data['agent_id'] || !$visitSchedule->start_at->equalTo($startAt) || !$visitSchedule->end_at->equalTo($endAt))) {
            return back()->withErrors(__('Jadwal yang sudah dibooking tidak dapat diubah waktunya.'))->withInput();
        }

        $this->ensureTimeslotIsValid($data['agent_id'], $startAt, $endAt, $visitSchedule->id);

        $visitSchedule->update([
            'agent_id' => $data['agent_id'],
            'start_at' => $startAt,
            'end_at' => $endAt,
            'location' => $data['location'] ?? null,
            'notes' => $data['notes'] ?? null,
            'status' => $visitSchedule->status === 'booked' ? $visitSchedule->status : $data['status'],
        ]);

        return redirect()
            ->route('admin.visit-schedules.index', ['tab' => 'visit-schedules'])
            ->with('success', __('Jadwal kunjungan diperbarui.'));
    }

    public function destroy(VisitSchedule $visitSchedule): RedirectResponse
    {
        if ($visitSchedule->isBooked()) {
            return back()->withErrors(__('Jadwal yang sudah dibooking tidak dapat dihapus.'));
        }

        $visitSchedule->delete();

        return redirect()
            ->route('admin.visit-schedules.index', ['tab' => 'visit-schedules'])
            ->with('success', __('Jadwal kunjungan dihapus.'));
    }

    public function close(VisitSchedule $visitSchedule): RedirectResponse
    {
        if ($visitSchedule->isBooked()) {
            return back()->withErrors(__('Tidak dapat menutup slot yang sudah dibooking pelanggan.'));
        }

        $visitSchedule->update([
            'status' => 'closed',
        ]);

        return back()->with('success', __('Jadwal ditandai sebagai tidak tersedia.'));
    }

    public function reopen(VisitSchedule $visitSchedule): RedirectResponse
    {
        if ($visitSchedule->isBooked()) {
            return back()->withErrors(__('Jadwal ini sedang dibooking pelanggan. Batalkan dulu untuk membuka slot.'));
        }

        $visitSchedule->update(['status' => 'available']);

        return back()->with('success', __('Jadwal dibuka kembali.'));
    }

    private function validateForm(Request $request): array
    {
        return $request->validate([
            'agent_id' => ['required', Rule::exists('users', 'id')->where('role', 'agen')],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'status' => ['nullable', 'in:available,booked,closed'],
        ]);
    }

    private function makeDateTime(string $date, string $time): Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i', $date.' '.$time);
    }

    private function ensureTimeslotIsValid(int $agentId, Carbon $startAt, Carbon $endAt, ?int $ignoreId = null): void
    {
        if ($endAt->lessThanOrEqualTo($startAt)) {
            throw ValidationException::withMessages([
                'end_time' => __('Waktu selesai harus lebih besar dari waktu mulai.'),
            ]);
        }

        if ($startAt->diffInMinutes($endAt) < 30) {
            throw ValidationException::withMessages([
                'end_time' => __('Durasi kunjungan minimal 30 menit.'),
            ]);
        }

        $bufferStart = (clone $startAt)->subMinutes(25);
        $bufferEnd = (clone $endAt)->addMinutes(25);

        $agentConflict = VisitSchedule::where('agent_id', $agentId)
            ->where('status', '!=', 'closed')
            ->when($ignoreId, fn ($query) => $query->where('id', '<>', $ignoreId))
            ->where(function ($query) use ($startAt, $endAt, $bufferStart, $bufferEnd) {
                $query->whereBetween('start_at', [$bufferStart, $bufferEnd])
                    ->orWhereBetween('end_at', [$bufferStart, $bufferEnd])
                    ->orWhere(function ($query) use ($bufferStart, $bufferEnd) {
                        $query->where('start_at', '<', $bufferStart)
                            ->where('end_at', '>', $bufferEnd);
                    })
                    ->orWhere(function ($query) use ($startAt, $endAt) {
                        $query->where('start_at', '<=', $startAt)
                            ->where('end_at', '>=', $endAt);
                    });
            })
            ->exists();

        if ($agentConflict) {
            throw ValidationException::withMessages([
                'start_time' => __('Jadwal ini terlalu dekat dengan jadwal lain agen yang sama (minimal jeda 25 menit).'),
            ]);
        }

        $overlappingCount = VisitSchedule::where('start_at', '<', $endAt)
            ->where('end_at', '>', $startAt)
            ->where('status', '!=', 'closed')
            ->when($ignoreId, fn ($query) => $query->where('id', '<>', $ignoreId))
            ->count();

        if ($overlappingCount >= 3) {
            throw ValidationException::withMessages([
                'start_time' => __('Slot waktu ini sudah memiliki jadwal maksimal (3 agen).'),
            ]);
        }
    }

    private function agents()
    {
        return User::query()
            ->where('role', 'agen')
            ->where('status', 'aktif')
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'status']);
    }
}





