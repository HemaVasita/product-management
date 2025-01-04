<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@mailinator.com'],
            [
                'password' => Hash::make('Admin@123'),
                'name' => 'Admin User',
                'email_verified_at' => now(),
            ]
        );
    }
}
