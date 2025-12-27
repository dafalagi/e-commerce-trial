<?php

use App\Models\HRIS\Auth\Permission as AuthPermission;
use Illuminate\Support\Facades\Auth;

// function have_permission($module_key) {
//     $permission = AuthPermission::where('module_key', $module_key)->first();
//     if ($permission != null) {
//         $check_access = count(Illuminate\Support\Facades\Auth::user()->userRole->role->rolePermission->where('permission_id', $permission['id']));
//         if ($check_access > 0) {
//             return true;
//         }
//     }
//     return false;
// }

// function permission_in ($array) {

//     foreach ($array as $row) {
//         if (have_permission($row)) return true;
//     }
//     return false;
// }
