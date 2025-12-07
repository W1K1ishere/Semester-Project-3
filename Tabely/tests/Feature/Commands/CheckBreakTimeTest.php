<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendWifi2BleRequestJob;

class CheckBreakAndRunCommandTest extends TestCase
{
/** @test */
    public function test_it_dispatches_the_break_when_time_matches()
    {
        // faking the dispatching of jobs, events, and commands. 
        // This is useful when you want to ensure that a job or command is dispatched without actually executing its logic
        Bus::fake();

        // time that is in the schedule list
        Carbon::setTestNowAndTimezone(Carbon::parse('11:00, Europe/Copenhagen'));

        Artisan::call('wifi2ble:checkbreak');

        // job was dispatched
        Bus::assertDispatched(SendWifi2BleRequestJob::class);
    }

    /** @test */
    public function test_it_does_not_dispatch_the_break_when_time_does_not_match()
    {
        Bus::fake();

        // time that is not in the list
        Carbon::setTestNow(Carbon::createFromTimeString('10:05'));

        Artisan::call('wifi2ble:checkbreak');

        // job was not dispatched
        Bus::assertNotDispatched(SendWifi2BleRequestJob::class);
    }
}
