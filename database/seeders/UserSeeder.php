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
            'username'   => 'adminBMKG',
            'password'   => Hash::make('AdminBMKG2025'), // ganti dengan password yang diinginkan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
