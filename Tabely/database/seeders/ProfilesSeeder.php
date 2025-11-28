<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('profiles')->insert([

    [
    'name'=>'default',
    'user_id'=>1,
    'standing_height'=>120,
    'sitting_height'=>90,
    'session_length'=>10
    ],
]);


    }
}
