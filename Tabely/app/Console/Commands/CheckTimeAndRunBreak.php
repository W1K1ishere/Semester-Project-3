<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendWifi2BleRequestBreak;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CheckTimeAndRunBreak extends Command
{
    protected $signature = 'wifi2ble:checkbreak';
    protected $description = 'Check the time and run the wifi2ble API request if it matches';

    protected $scheduledTimes = [
        '09:00',
        '11:12',
        '11:13',
        '11:14',
        '19:30',
        '19:31',
        '19:32',
        '19:33',
        '19:34',
        '19:35',
        '19:36',
        '19:37',
        '19:38',
        '19:39',
        '19:40',
        '19:41',
        '19:42',
    ];

    public function handle()
{
    $now = Carbon::now()->format('H:i');

    Log::info("⏱ Scheduler running, current time: {$now}");

    foreach ($this->scheduledTimes as $time) {
        if ($time === $now) {
              SendWifi2BleRequestBreak::dispatch();

            Log::info(" Time matched ({$now}) — job dispatched");
        }
    }
}

}
