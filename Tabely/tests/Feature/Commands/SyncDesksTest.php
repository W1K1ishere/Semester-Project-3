<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Table;
use Illuminate\Support\Facades\Bus;

class SyncDesksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_syncs_desks_and_creates_missing_records()
    {
        // Mock API response
        Http::fake([
            'http://127.0.0.1:8080/api/v2/*/desks' => Http::response([
                'desks' => [
                    'AA:BB:CC:DD:EE:01',
                    'AA:BB:CC:DD:EE:02',
                ]
            ], 200)
        ]);

        // Run command
        Artisan::call('desks:sync');

        // Check console output
        $this->assertStringContainsString('Desks synced', Artisan::output());

        // Assert database entries
        $this->assertDatabaseHas('tables', [
            'desk_mac' => 'AA:BB:CC:DD:EE:01',
            'current_height' => 0,
            'department_id' => null,
            'user_id' => null,
            'isAssigned' => false,
        ]);

        $this->assertDatabaseHas('tables', [
            'desk_mac' => 'AA:BB:CC:DD:EE:02',
        ]);

        // Should create exactly 2 rows
        $this->assertEquals(2, Table::count());
    }

    /** @test */
    public function test_it_outputs_error_if_request_fails()
    {
        Http::fake([
            '*' => Http::response([], 500)
        ]);

        Artisan::call('desks:sync');

        $this->assertStringContainsString('Failed to fetch desks', Artisan::output());
        $this->assertEquals(0, Table::count());
    }
}
