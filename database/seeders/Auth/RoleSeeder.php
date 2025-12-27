<?php

namespace Database\Seeders\Auth;

use App\Models\Auth\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Master Admin',
                'code' => 'master_admin',
                'description' => 'Master Admin',
                'envs_eligibility' => 'admin',
            ],
        ];

        foreach($roles as $role) {
            Role::factory()->create([
                'name' => $role['name'],
                'code' => $role['code'],
                'description' => $role['description'],
                'is_default' => true,
                'envs_eligibility' => $role['envs_eligibility'],
            ]);
        }
    }
}
