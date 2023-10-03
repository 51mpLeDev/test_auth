<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'login' => 'admin',
            'email' => 'admin@gmail.com',
            'api_token' => 'ee977806d7286510da8b9a7492ba58e2484c0ecc',
            'password' => Hash::make('password')
        ]);
    }
}
