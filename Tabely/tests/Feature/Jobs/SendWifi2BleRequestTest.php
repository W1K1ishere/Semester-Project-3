<?php

namespace Tests\Unit\Jobs;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendWifi2BleRequestJob;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendWifi2BleRequestJobTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_logs_error_if_table_not_found()
{
    Log::shouldReceive('info');
    Log::shouldReceive('error')->once()
        ->with('❌ Table not found', ['table_id' => 999]);

    $job = new SendWifi2BleRequestJob(999, 1000);
    $job->handle();
}


    /** @test */
    public function test_it_sends_put_request_and_logs_success_when_api_returns_success()
    {
        $deskMac = 'AA:BB:CC:DD:EE:FF';
        $tableId = DB::table('tables')->insertGetId([
            'desk_mac'       => $deskMac,
            'current_height' => 0,
            'department_id'  => null,
            'user_id'        => null,
            'isAssigned'     => false,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        Http::fake([
            "http://127.0.0.1:8080/api/v2/*/desks/{$deskMac}/state" => Http::response(['success' => true], 200),
        ]);

        Log::shouldReceive('info')->once()->with('📡 SendWifi2BleRequestJob started', [
            'table_id' => $tableId,
            'desired_position_mm' => 1000
        ]);

        Log::shouldReceive('info')->once()->with('📤 PUT Request', \Mockery::on(function ($arg) use ($deskMac) {
            return $arg['url'] === "http://127.0.0.1:8080/api/v2/E9Y2LxT4g1hQZ7aD8nR3mWx5P0qK6pV7/desks/{$deskMac}/state"
                && $arg['position_mm'] === 1000;
        }));

        Log::shouldReceive('info')->once()->with('🟢 Desk movement command accepted', \Mockery::on(function ($arg) use ($deskMac) {
            return $arg['desk_mac'] === $deskMac
                && $arg['response'] === ['success' => true];
        }));

        $job = new SendWifi2BleRequestJob($tableId, 1000);
        $job->handle();
    }

    /** @test */
    public function test_it_logs_error_when_api_returns_failure()
    {
        $deskMac = 'AA:BB:CC:DD:EE:11';
        $tableId = DB::table('tables')->insertGetId([
            'desk_mac'       => $deskMac,
            'current_height' => 0,
            'department_id'  => null,
            'user_id'        => null,
            'isAssigned'     => false,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        Http::fake([
            "http://127.0.0.1:8080/api/v2/*/desks/{$deskMac}/state" => Http::response(['error' => 'Not found'], 404),
        ]);

        Log::shouldReceive('info')->once(); // job started
        Log::shouldReceive('info')->once(); // and this should be the put request
        Log::shouldReceive('error')->once()->with('❌ Desk failed to raise', \Mockery::on(function ($arg) use ($deskMac) {
            return $arg['desk_mac'] === $deskMac
                && $arg['status'] === 404
                && $arg['body'] === json_encode(['error' => 'Not found']);
        }));

        $job = new SendWifi2BleRequestJob($tableId, 1000);
        $job->handle();
    }
}
