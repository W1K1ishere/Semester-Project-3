<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendWifi2BleRequestJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CheckTimeAndRunCommandEndCleaning extends Command
{
    protected $signature = 'wifi2ble:checktimecleaningend';
    protected $description = 'Check the time against department cleaning times and update table heights based on user profiles';

    public function handle()
    {
       $now = Carbon::now('Europe/Copenhagen')->format('H:i');
Log::info("⏱ Scheduler running at {$now}");

// get departments scheduled at this time
$departments = DB::table('departments')
    ->where('cleaning_time_end', $now)
    ->get();

Log::info("Departments found:", $departments->toArray());

if ($departments->isEmpty()) {
    Log::info("No departments scheduled to end cleaning at {$now}");
    return;
}

foreach ($departments as $department) {
    Log::info("Processing department ID: {$department->id}");

    // getting tables for the department
    $tables = DB::table('tables')
        ->where('department_id', $department->id)
        ->get();

    Log::info("Tables found for department {$department->id}:", $tables->toArray());

    if ($tables->isEmpty()) {
        Log::info("No tables in this department.");
        continue;
    }

    foreach ($tables as $table) {
        Log::info("Processing table ID: {$table->id}");

        //user assigned to this table
        if (is_null($table->user_id)) {
            Log::info("Table {$table->id} has no assigned user.");
            continue;
        }

        $user = DB::table('users')
            ->where('id', $table->user_id)
            ->first();

        Log::info("User found for table {$table->id}:", (array) $user);

        if (!$user || is_null($user->picked_profile)) {
            Log::info("User {$table->user_id} has no picked_profile.");
            continue;
        }

        //   profile from picked_profile
        $profile = DB::table('profiles')
            ->where('id', $user->picked_profile)
            ->where('user_id', $user->id)
            ->first();

        Log::info("Profile found for user {$user->id}:", (array) $profile);

        if (!$profile) {
            Log::info("No matching profile found for user {$user->id} and profile ID {$user->picked_profile}.");
            continue;
        }

        // sendjob with standing_height
        Log::info("Dispatching job for table {$table->id} with standing_height {$profile->sitting_height}");
        SendWifi2BleRequestJob::dispatch($table->id, $profile->sitting_height*10);
    }
}

    }
}
