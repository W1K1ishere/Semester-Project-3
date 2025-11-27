<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendWifi2BleRequestJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckTimeAndRunCommand extends Command
{
    protected $signature = 'wifi2ble:checktime';
    protected $description = 'Check the time and run the wifi2ble API request if it matches';

    protected $scheduledTimes = [
        '09:00',
        '11:12',
        '11:13',
        '11:14',
        '12:19',
    ];

    public function handle()
{
    $now = Carbon::now()->format('H:i');

    Log::info("⏱ Scheduler running, current time: {$now}");

    foreach ($this->scheduledTimes as $time) {
        if ($time === $now) {
              SendWifi2BleRequestJob::dispatch();

            Log::info(" Time matched ({$now}) — job dispatched");
        }
    }
}

}
