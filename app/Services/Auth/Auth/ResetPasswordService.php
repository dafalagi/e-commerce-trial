<?php

namespace App\Services\Auth\Auth;

use App\Models\Auth\User;
use App\Services\DefaultService;
use App\Services\ServiceInterface;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;

class ResetPasswordService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $status = Password::reset(
            collect($dto)->only(['email', 'password', 'password_confirmation', 'token'])->all(),
            function(User $user, string $password) {
                app('UpdateUserService')->execute([
                    'user_id' => $user->id,
                    'password' => $password,
                    'version' => $user->version,
                ], true);

                event(new PasswordReset($user));
            }
        );

        if($status !== Password::PasswordReset)
            throw new \Exception(__($status), 500);

        $this->results['data'] = [];
        $this->results['message'] = __('success.auth.auth.password_reset');
    }

    public function prepare($dto)
    {
        return $dto;
    }

    public function rules($dto)
    {
        return [
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'exists:auth_users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
