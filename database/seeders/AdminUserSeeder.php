<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'bjudeclarence@gmail.com',
            'password' => Hash::make('password'), // Change 'password' to a secure password
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}