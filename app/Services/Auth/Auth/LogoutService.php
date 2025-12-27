<?php

namespace App\Services\Auth\Auth;

use App\Services\DefaultService;
use App\Services\ServiceInterface;
use Illuminate\Support\Facades\Auth;

class LogoutService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $user = Auth::user();
        $this->revokeAccessAndRefreshToken($user);

        $this->results['data'] = [];
        $this->results['message'] = __('success.auth.auth.logout');
    }

    private function revokeAccessAndRefreshToken($user)
    {
        $user->tokens()->each(function($token) {
            $token->revoke();
            $token->delete();

            $refresh_token_repository = app('\Laravel\Passport\RefreshTokenRepository');
            $refresh_token_repository->revokeRefreshTokensByAccessTokenId($token->id);
        });
    }
}
