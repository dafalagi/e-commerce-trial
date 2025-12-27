<?php

namespace App\Providers\RegisterService;

use App\Providers\AppServiceProvider;

class RegisterAuthFeatService extends AppServiceProvider
{
    public function register(): void
    {
        /** User */
        $this->registerService('StoreUserService', \App\Services\Auth\User\StoreUserService::class);
        $this->registerService('UpdateUserService', \App\Services\Auth\User\UpdateUserService::class);
        $this->registerService('DeleteUserService', \App\Services\Auth\User\DeleteUserService::class);
        $this->registerService('GetUserService', \App\Services\Auth\User\GetUserService::class);
        $this->registerService('CreateUserService', \App\Services\Auth\User\CreateUserService::class);

        /** Auth */
        $this->registerService('LoginService', \App\Services\Auth\Auth\LoginService::class);
        $this->registerService('LogoutService', \App\Services\Auth\Auth\LogoutService::class);
        $this->registerService('GetUserSessionService', \App\Services\Auth\Auth\GetUserSessionService::class);
        $this->registerService('ChangePasswordService', \App\Services\Auth\Auth\ChangePasswordService::class);
        $this->registerService('ForgotPasswordService', \App\Services\Auth\Auth\ForgotPasswordService::class);
        $this->registerService('ResetPasswordService', \App\Services\Auth\Auth\ResetPasswordService::class);

        /** Role */
        $this->registerService('StoreRoleService', \App\Services\Auth\Role\StoreRoleService::class);
        $this->registerService('UpdateRoleService', \App\Services\Auth\Role\UpdateRoleService::class);
        $this->registerService('DeleteRoleService', \App\Services\Auth\Role\DeleteRoleService::class);
        $this->registerService('GetRoleService', \App\Services\Auth\Role\GetRoleService::class);
        $this->registerService('RemoveRoleService', \App\Services\Auth\Role\RemoveRoleService::class);

        /** User Role */
        $this->registerService('AddUserRoleService', \App\Services\Auth\UserRole\AddUserRoleService::class);
        $this->registerService('RemoveUserRoleService', \App\Services\Auth\UserRole\RemoveUserRoleService::class);

        /** Role Permission */
        $this->registerService('UpdateRolePermissionService', \App\Services\Auth\RolePermission\UpdateRolePermissionService::class);

        /** Permission */
        $this->registerService('GetPermissionService', \App\Services\Auth\Permission\GetPermissionService::class);
    }
}