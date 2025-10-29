<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\VisitSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VisitScheduleBookingController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        // Only show future slots. Some older data may lack end_at, so rely on start_at.
        $availableSlots = VisitSchedule::with('agent')
            ->available()
            ->where('start_at', '>=', now())
            ->orderBy('start_at')
            ->get();

        $myBookings = VisitSchedule::with('agent')
            ->where('customer_id', $user->id)
            ->orderBy('start_at')
            ->get();

        return view('pelanggan.jadwal.index', [
            'availableSlots' => $availableSlots,
            'myBookings' => $myBookings,
        ]);
    }

    public function book(Request $request, VisitSchedule $visitSchedule): RedirectResponse
    {
        $user = $request->user();

        if ($visitSchedule->status !== 'available' || $visitSchedule->customer_id !== null) {
            return back()->withErrors(__('Slot kunjungan ini sudah tidak tersedia.')); 
        }

        if ($visitSchedule->start_at->isPast()) {
            return back()->withErrors(__('Tidak dapat membooking jadwal yang sudah terlewat.'));
        }

        $hasBookingSameDay = VisitSchedule::where('customer_id', $user->id)
            ->whereDate('start_at', $visitSchedule->start_at->toDateString())
            ->exists();

        if ($hasBookingSameDay) {
            return back()->withErrors(__('Anda sudah memiliki jadwal pada tanggal ini.'));
        }

        $hasUpcoming = VisitSchedule::where('customer_id', $user->id)
            ->where('status', 'booked')
            ->where('start_at', '>=', now())
            ->exists();

        if ($hasUpcoming) {
            return back()->withErrors(__('Anda sudah memiliki jadwal kunjungan aktif. Batalkan jadwal sebelumnya untuk membooking yang baru.'));
        }

        $visitSchedule->update([
            'status' => 'booked',
            'customer_id' => $user->id,
            'booked_at' => now(),
        ]);

        return redirect()
            ->route('pelanggan.jadwal.index')
            ->with('success', __('Jadwal kunjungan berhasil dibooking. Tim kami akan menghubungi Anda untuk konfirmasi lanjutan.'));
    }

    public function cancel(Request $request, VisitSchedule $visitSchedule): RedirectResponse
    {
        $user = $request->user();

        if ($visitSchedule->customer_id !== $user->id) {
            abort(403);
        }

        if ($visitSchedule->start_at->isPast()) {
            return back()->withErrors(__('Tidak dapat membatalkan jadwal yang sudah lewat.'));
        }

        $visitSchedule->update([
            'status' => 'available',
            'customer_id' => null,
            'booked_at' => null,
        ]);

        return redirect()
            ->route('pelanggan.jadwal.index')
            ->with('success', __('Jadwal kunjungan berhasil dibatalkan.'));
    }
}
