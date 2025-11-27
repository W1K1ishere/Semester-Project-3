<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendWifi2BleRequestBreak;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckBreakAndRunCommand extends Command
{
    protected $signature = 'wifi2ble:checktime';
    protected $description = 'Check the time and run the wifi2ble API request if it matches';

    protected $scheduledTimes = [
        '12:00',
        '15:00',
    ];

    public function handle()
{
    $now = Carbon::now()->format('H:i');

    Log::info("⏱ Scheduler running, current time: {$now}");

    foreach ($this->scheduledTimes as $time) {
        if ($time === $now) {
              SendWifi2BleRequestBreak::dispatch();

            Log::info(" Time matched ({$now}) — break dispatched");
        }
    }
}

}
