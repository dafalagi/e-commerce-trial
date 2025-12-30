<?php

namespace Database\Seeders\Auth;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::where('code', 'admin')->first();
        app('CreateUserService')->execute([
            'email' => config('credential.default_email'),
            'password' => config('credential.default_password'),
            'password_confirmation' => config('credential.default_password'),
            'name' => 'Developer',
            'phone_number' => '081234567890',
            'role_uuid' => $admin->uuid,
        ]);
    }
}
