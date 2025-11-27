<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departments')->insert([
    [
        'dep_name' => 'No department',
        'break_time_start' => '10:00:00',
        'break_time_end'   => '10:15:00',
        'cleaning_time_start' => '14:00:00',
        'cleaning_time_end'   => '14:20:00',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'dep_name' => 'Quality',
        'break_time_start' => '11:00:00',
        'break_time_end'   => '11:15:00',
        'cleaning_time_start' => '16:00:00',
        'cleaning_time_end'   => '16:20:00',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'dep_name' => 'Maintenance',
        'break_time_start' => '09:00:00',
        'break_time_end'   => '09:20:00',
        'cleaning_time_start' => '13:00:00',
        'cleaning_time_end'   => '13:20:00',
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
