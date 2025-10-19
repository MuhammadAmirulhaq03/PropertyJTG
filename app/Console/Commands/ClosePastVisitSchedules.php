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
    protected $description = 'Automatically close visit schedules whose end time has passed.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = now();

        $closedAvailable = VisitSchedule::query()
            ->where('end_at', '<', $now)
            ->where('status', 'available')
            ->update(['status' => 'closed']);

        $closedBooked = 0;

        VisitSchedule::query()
            ->where('end_at', '<', $now)
            ->where('status', 'booked')
            ->chunkById(200, function ($schedules) use (&$closedBooked) {
                DB::transaction(function () use ($schedules, &$closedBooked) {
                    foreach ($schedules as $schedule) {
                        $schedule->update([
                            'status' => 'closed',
                            'customer_id' => null,
                            'booked_at' => null,
                        ]);
                        $closedBooked++;
                    }
                });
            });

        $total = $closedAvailable + $closedBooked;

        $this->info("Closed {$total} past visit schedule(s).");

        return self::SUCCESS;
    }
}

