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
        $master_admin = Role::where('code', 'master_admin')->first();
        app('CreateUserService')->execute([
            'email' => 'developer@wangun.co',
            'password' => 'password',
            'password_confirmation' => 'password',
            'name' => 'Developer',
            'phone_number' => '081234567890',
            'role_uuid' => $master_admin->uuid,
        ]);
    }
}
