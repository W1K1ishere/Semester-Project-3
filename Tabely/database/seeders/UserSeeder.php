<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([

    [
        'id'=>1,
        'name'=>'default',
        'email'=>'test@test.test',
        'password'=>bcrypt('testtest'),
        'height'=>190,
        'phone'=>'+12345',
        'isAdmin'=>true,
        'picked_profile'=>1
    ],
]);


    }
}
