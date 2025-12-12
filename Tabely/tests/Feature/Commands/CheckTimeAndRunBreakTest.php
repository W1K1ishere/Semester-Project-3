<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\SendWifi2BleRequestJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;
use App\Jobs\AnotherJob;
use App\Jobs\ShipOrder;
use Illuminate\Support\Facades\Http;


class CheckTimeAndRunBreakTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
public function test_it_dispatches_a_break_for_tables_with_valid_users_and_profiles()
{
  
    Http::fake(['http://127.0.0.1:8080/api/v2/*' => Http::response(['success' => true], 200),]);
    
    Bus::fake();
    Carbon::setTestNow(Carbon::create(2023, 1, 1, 9, 30, 0, 'Europe/Copenhagen'));
    $now = Carbon::now('Europe/Copenhagen')->format('H:i');

     // dep w current time
    $deptId = DB::table('departments')->insertGetId([
        'dep_name' => 'IT',
        'break_time_start' => $now, 
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // user w picked_profile
    $userId = DB::table('users')->insertGetId([
        'name' => 'John',
        'email' => 'john@example.com',
        'password' => bcrypt('password'),
        'picked_profile' => 5,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // matching profile to user
    DB::table('profiles')->insert([
        'id' => 5,
        'user_id' => $userId,
        'name' => 'Standing Profile',
        'standing_height' => 100,
        'sitting_height' => 50,
        'session_length' => 15,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // table in department + user
    $tableId = DB::table('tables')->insertGetId([
        'desk_mac'       => 'AA:BB:CC:DD:EE:FF',
        'current_height' => 0,
        'department_id'  => $deptId,
        'user_id'        => $userId,
        'isAssigned'     => true,
        'created_at'     => now(),
        'updated_at'     => now(),
    ]);


    Artisan::call('wifi2ble:checkbreak');

    // assert job
    Bus::assertDispatched(SendWifi2BleRequestJob::class, function ($job) use ($tableId) {
        $reflection = new \ReflectionClass($job);
        $tableProp = $reflection->getProperty('tableId');
        $tableProp->setAccessible(true);
        return $tableProp->getValue($job) === $tableId;
    });
}

    /** @test */
public function test_it_does_not_dispatch_jobs_if_no_departments_match_the_time()
    {
        Queue::fake();

        // No departments 

        Artisan::call('wifi2ble:checkbreak');

        Queue::assertNothingPushed();
    }


    /** @test */
public function test_it_skips_tables_without_users()
    {
    
    Carbon::setTestNow('10:00');
    $now = Carbon::now()->format('H:i');

    $deptId = DB::table('departments')->insertGetId([
    'dep_name' => 'the billy department',
    'break_time_start' => $now,
    'created_at' => now(),
    'updated_at' => now(),
    ]);

    // tables but no user
    DB::table('tables')->insert([
    'desk_mac'       => 'AA:BB:CC:DD:EE-' . rand(1000,9999),
    'current_height' => 0,
    'department_id'  => $deptId,
    'user_id'        => null,
    'isAssigned'     => false,
    'created_at'     => now(),
    'updated_at'     => now(),
    ]);


    Bus::fake();
    Artisan::call('wifi2ble:checkbreak');

    // assert no job dispatched
    Bus::assertNotDispatched(SendWifi2BleRequestJob::class);
}


    /** @test */
public function test_it_skips_users_without_picked_profile()
    {
        Queue::fake();

        Carbon::setTestNow('11:00');
        $now = Carbon::now()->format('H:i');

        $deptId = DB::table('departments')->insertGetId([
        'dep_name' => 'IT',
        'break_time_start' => $now,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $userId = DB::table('users')->insertGetId([
        'name' => 'John',
        'email' => 'john@example.com',
        'password' => bcrypt('password'),
        'picked_profile' => 5,
        'created_at' => now(),
        'updated_at' => now(),
   
    ]);

    DB::table('profiles')->insert([
        'id' => 5,
        'user_id' => $userId,
        'name' => 'Standing Profile',
        'standing_height' => 100,
        'sitting_height' => 50,
        'session_length' => 15,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

        Artisan::call('wifi2ble:checkbreak');

        Queue::assertNothingPushed();
}



    /** @test */
public function test_it_skips_if_profile_does_not_exist()
    {
        Queue::fake();

        Carbon::setTestNow('12:00');
        $now = Carbon::now()->format('H:i');

    $deptId = DB::table('departments')->insertGetId([
        'dep_name' => 'IT',
        'break_time_start' => $now,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

            $userId = DB::table('users')->insertGetId([
        'name' => 'John',
        'email' => 'john@example.com',
        'password' => bcrypt('password'),
        'picked_profile' => 1535,
        'created_at' => now(),
        'updated_at' => now(),
   
    ]);

    DB::table('tables')->insert([
    'desk_mac'       => 'AA:BB:CC:DD:EE-' . rand(1000,9999),
    'current_height' => 0,
    'department_id'  => $deptId,
    'user_id'        => null,
    'isAssigned'     => false,
    'created_at'     => now(),
    'updated_at'     => now(),
    ]);

        Artisan::call('wifi2ble:checkbreak');

        Queue::assertNothingPushed();
}
}