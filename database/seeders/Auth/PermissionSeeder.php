<?php

namespace Database\Seeders\Auth;

use App\Models\Auth\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = config('permission');

        foreach($permissions as $permission) {
            $module_key = generate_to_snake_case(strtolower($permission['module_name']) . '_' . strtolower($permission['permission_name']));

            $permission_exists = Permission::where('module_key', $module_key)->first();
            if($permission_exists) continue;

            Permission::create([
                'uuid' => generate_uuid(),
                'module_key' => $module_key,
                'module_name' => $permission['module_name'],
                'permission_name' => $permission['permission_name'],
            ]);
        }
    }
}
