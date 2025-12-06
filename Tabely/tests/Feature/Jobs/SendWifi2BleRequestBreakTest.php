<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Bus;
use App\Jobs\SendWifi2BleRequestBreak;

class SendWifi2BleRequestBreakTest extends TestCase
{
    /** @test */
    public function test_it_fetches_desks_and_sends_put_break_requests()
    {
        //  http calls
        Http::fake([
            'http://localhost:8080/api/v2/*/desks' => Http::response([101, 202], 200),
            'http://127.0.0.1:8080/api/v2/*/desks/*/state' => Http::response(['ok' => true], 200),
        ]);

        // Run the job
        (new SendWifi2BleRequestBreak())->handle();

        // Assert GET request was called once
        Http::assertSent(function ($request) {
            return $request->url() ===
                'http://localhost:8080/api/v2/E9Y2LxT4g1hQZ7aD8nR3mWx5P0qK6pV7/desks'
                && $request->method() === 'GET';
        });

        // assert two put requests were sent 
        Http::assertSent(function ($request) {
            return $request->method() === 'PUT'
                && str_contains($request->url(), '/desks/')
                && str_contains($request->url(), '/state');
        });

        Http::assertSentCount(3); // 1 GET + 2 PUT
    }

    /** @test */
/** @test */
public function test_it_logs_error_when_desk_fetch_fails()
{
    Http::fake([
        'http://localhost:8080/api/v2/*/desks' => Http::response([], 500),
    ]);

    // Allow all log calls by default
    Log::shouldReceive('info')->byDefault();
    Log::shouldReceive('error')
        ->once()
        ->with('❌ Failed to fetch desks', ['status' => 500]);

    (new SendWifi2BleRequestBreak())->handle();
}

}
