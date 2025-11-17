<?php

namespace App\Console\Commands;

use App\Models\VisitSchedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClosePastVisitSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visit-schedules:close-past';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically update visit schedules whose end time has passed.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = now();

        // Slot kosong yang sudah lewat: ditutup agar tidak bisa dibooking
        $closedAvailable = VisitSchedule::query()
            ->where('end_at', '<', $now)
            ->where('status', 'available')
            ->update(['status' => 'closed']);

        // Slot yang sudah dibooking dan waktunya lewat: tandai sebagai selesai (completed)
        $completedBooked = VisitSchedule::query()
            ->where('end_at', '<', $now)
            ->where('status', 'booked')
            ->update(['status' => 'completed']);

        $total = $closedAvailable + $completedBooked;

        $this->info("Updated {$total} past visit schedule(s).");

        return self::SUCCESS;
    }
}
