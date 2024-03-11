<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateExpiredSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-expired-schedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marks expired schedules as such in the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        Schedule::where(function ($query) use ($now) {
            $query->where('date', '<', $now->toDateString())
                ->orWhere(function ($query) use ($now) {
                    $query->where('date', $now->toDateString())
                        ->whereTime('time', '<', $now->toTimeString());
                });
        })->update(['expired' => true]);

        $this->info('Expired schedules updated successfully.');
    }

}
