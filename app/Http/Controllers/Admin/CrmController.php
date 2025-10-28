<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CrmController extends Controller
{
    /**
     * Display customer CRM workspace for administrators.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $statusFilter = $request->input('status', 'all');
        $availabilityFilter = $request->input('availability', 'all');

        $lastActivitySubquery = DB::table('sessions')
            ->select('user_id', DB::raw('MAX(last_activity) as last_activity'))
            ->groupBy('user_id');

        $customersQuery = User::query()
            ->leftJoinSub($lastActivitySubquery, 'session_activity', function ($join) {
                $join->on('session_activity.user_id', '=', 'users.id');
            })
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'users.phone',
                'users.alamat',
                'users.status',
                'users.last_seen_at',
                'session_activity.last_activity',
            ])
            ->where('users.role', 'customer');

        if ($search !== '') {
            $customersQuery->where(function ($query) use ($search) {
                $query->where('users.name', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%')
                    ->orWhere('users.phone', 'like', '%' . $search . '%');
            });
        }

        if (in_array($statusFilter, ['aktif', 'nonaktif'], true)) {
            $customersQuery->where('users.status', $statusFilter);
        }

        $rawCustomers = $customersQuery
            ->orderBy('users.name')
            ->get();

        $onlineThreshold = now()->subMinutes(5);

        $customers = $rawCustomers->map(function ($customer) use ($onlineThreshold) {
            $lastActivity = $customer->last_seen_at
                ? Carbon::parse($customer->last_seen_at)
                : ($customer->last_activity ? Carbon::createFromTimestamp($customer->last_activity) : null);

            $isOnline = $lastActivity && $lastActivity->greaterThan($onlineThreshold);

            $phoneDigits = preg_replace('/\D+/', '', (string) $customer->phone);
            if ($phoneDigits) {
                if (Str::startsWith($phoneDigits, '0')) {
                    $phoneDigits = '62' . substr($phoneDigits, 1);
                } elseif (!Str::startsWith($phoneDigits, '62')) {
                    $phoneDigits = '62' . ltrim($phoneDigits, '0');
                }
            }

            $documentReminderLink = 'mailto:' . $customer->email
                . '?subject=' . rawurlencode('Pengingat Dokumen KPR')
                . '&body=' . rawurlencode("Halo {$customer->name},\n\nKami ingin mengingatkan Anda untuk melengkapi dokumen yang dibutuhkan di portal pelanggan.\nSilakan login untuk melanjutkan proses.\n\nSalam,\nTim Jaya Tibar Group");

            $scheduleReminderLink = 'mailto:' . $customer->email
                . '?subject=' . rawurlencode('Pengingat Jadwal Booking')
                . '&body=' . rawurlencode("Halo {$customer->name},\n\nKami ingin mengingatkan jadwal kunjungan atau booking Anda bersama Jaya Tibar Group.\nHubungi kami jika membutuhkan perubahan jadwal.\n\nSalam,\nTim Jaya Tibar Group");

            return (object) [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'alamat' => $customer->alamat,
                'status' => $customer->status,
                'is_online' => $isOnline,
                'last_seen_at' => $lastActivity,
                'last_seen_label' => $lastActivity ? $lastActivity->diffForHumans() : __('Belum pernah login'),
                'email_link' => 'mailto:' . $customer->email,
                'whatsapp_link' => $phoneDigits ? 'https://wa.me/' . $phoneDigits : null,
                'document_reminder_link' => $documentReminderLink,
                'schedule_reminder_link' => $scheduleReminderLink,
            ];
        });

        $stats = [
            'total' => $customers->count(),
            'online' => $customers->where('is_online', true)->count(),
            'aktif' => $customers->where('status', 'aktif')->count(),
            'nonaktif' => $customers->where('status', 'nonaktif')->count(),
        ];

        if ($availabilityFilter === 'online') {
            $customers = $customers->where('is_online', true)->values();
        } elseif ($availabilityFilter === 'offline') {
            $customers = $customers->where('is_online', false)->values();
        }

        return view('admin.crm.index', [
            'selectedTab' => 'crm',
            'customers' => $customers,
            'stats' => $stats,
            'filters' => [
                'search' => $search,
                'status' => $statusFilter,
                'availability' => $availabilityFilter,
            ],
        ]);
    }
}
