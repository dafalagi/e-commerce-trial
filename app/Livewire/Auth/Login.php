<?php

namespace App\Livewire\Auth;

use App\Traits\WithToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class Login extends Component
{
    use WithToast;
    
    public $email = '';
    public $password = '';
    public $remember = false;
    public $timezone = '';

    protected $rules = [
        'email' => ['required', 'email'],
        'password' => ['required', 'string', 'min:8'],
    ];
    
    public function login()
    {
        $this->validate();
        
        $credentials = ['email' => $this->email, 'password' => $this->password];
        
        if (!Auth::attempt($credentials, $this->remember)) {
            $this->showErrorToast('These credentials do not match our records.');
            return;
        }
        
        if ($this->remember) {
            $this->setRememberTokenExpiry();
        }

        app('UpdateUserService')->execute([
            'user_id' => Auth::user()->id,
            'timezone' => $this->timezone,
            'version' => Auth::user()->version,
        ]);
        
        $this->showSuccessToast('Login successful! Welcome back!');

        $this->dispatch('login-success');
    }

    public function setRememberTokenExpiry()
    {
        $remember_token_expiry = config('session.remember_token_expiry');
        $remember_token_name = Auth::getRecallerName();

        Cookie::queue($remember_token_name, Cookie::get($remember_token_name), $remember_token_expiry);
    }

    public function redirectToProducts()
    {
        session()->regenerate();

        $this->redirect(route('products.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
