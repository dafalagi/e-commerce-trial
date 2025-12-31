<?php

namespace App\Livewire\Auth;

use App\Models\Auth\User;
use App\Traits\WithToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Login extends Component
{
    use WithToast;
    
    public $email = '';
    public $password = '';
    public $remember = false;
    public $timezone = '';
    public $user = null;

    protected $rules = [
        'email' => ['required', 'email'],
        'password' => ['required', 'string', 'min:8'],
    ];
    
    public function login()
    {
        $this->validate();
        
        if (!$this->checkUser()) {
            $this->showErrorToast('These credentials do not match our records.');
            return;
        }
        
        $this->showSuccessToast('Login successful! Welcome back!');

        $this->dispatch('login-success');
    }

    public function checkUser()
    {
        $this->user = User::where('email', $this->email)->first();

        return $this->user && Hash::check($this->password, $this->user->password);
    }

    public function setRememberTokenExpiry()
    {
        $remember_token_expiry = config('session.remember_token_expiry');
        $remember_token_name = Auth::getRecallerName();

        Cookie::queue($remember_token_name, Cookie::get($remember_token_name), $remember_token_expiry);
    }

    public function redirectToProducts()
    {
        app('UpdateUserService')->execute([
            'user_id' => $this->user->id,
            'timezone' => $this->timezone,
            'version' => $this->user->version,
        ]);

        Auth::login($this->user, $this->remember);
        session()->regenerate();

        if ($this->remember) {
            $this->setRememberTokenExpiry();
        }

        $this->redirect(route('products.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
