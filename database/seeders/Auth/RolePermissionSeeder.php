<?php

namespace Database\Seeders\Auth;

use App\Models\Auth\Permission;
use App\Models\Auth\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::all();
        $permissions_config = config('permission');

        foreach($permissions as $permission) {
            $role_permission_exists = RolePermission::where('role_id', 1)
                ->where('permission_id', $permission->id)
                ->first();
            if($role_permission_exists) continue;

            RolePermission::create([
                'role_id' => 1,
                'permission_id' => $permission->id,
            ]);

            $permission_config = collect($permissions_config)->where('module_name', $permission->module_name)
                ->where('permission_name', $permission->permission_name)
                ->first();
                
            if(isset($permission_config['non_admin_env_default']) && $permission_config['non_admin_env_default']) {
                $role_permission_exists = RolePermission::where('role_id', 2)
                    ->where('permission_id', $permission->id)
                    ->first();
                if($role_permission_exists) continue;

                RolePermission::create([
                    'role_id' => 2,
                    'permission_id' => $permission->id,
                ]);
            }
        }
    }
}
