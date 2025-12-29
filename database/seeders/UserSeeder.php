<?php

namespace Database\Seeders;

use App\Models\Auth\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        
        User::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }
}
