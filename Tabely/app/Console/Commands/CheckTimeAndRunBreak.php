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


    public function handle()
{
    $now = Carbon::now()->format('H:i');

    $breakTimes = DB::table('breaks')->get();

    Log::info("⏱ Scheduler running, current time: {$now}");

    foreach ($breakTimes as $break) {
        
        //this was to test formatting stuff
        /*
        if (true) {
              SendWifi2BleRequestBreak::dispatch();
              $willthiswork = date('H:i', $break->startTime);
              
            Log::info(" Time matched ({$now}) ({$willthiswork})— job dispatched");
        }
        */

        if (date('H:i', $break->startTime) === $now) {
              SendWifi2BleRequestBreak::dispatch();

            Log::info(" Time matched ({$now}) — job dispatched");
        }
        
    }
}

}
