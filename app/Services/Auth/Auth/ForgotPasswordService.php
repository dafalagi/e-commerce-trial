<?php

namespace App\Services\Auth\Auth;

use App\Services\DefaultService;
use App\Services\ServiceInterface;
use Illuminate\Support\Facades\Password;

class ForgotPasswordService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $status = Password::sendResetLink(
            ['email' => $dto['email']]
        );

        if($status !== Password::ResetLinkSent)
            throw new \Exception(__($status));

        $this->results['data'] = $dto['email'];
        $this->results['message'] = __('success.auth.auth.reset_link_sent', ['email' => $dto['email']]);
    }

    public function prepare($dto)
    {
        return $dto;
    }

    public function rules($dto)
    {
        return [
            'email' => ['required', 'email', 'exists:auth_users,email']
        ];
    }
}
