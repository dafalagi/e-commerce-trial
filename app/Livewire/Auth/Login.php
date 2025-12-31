<?php

namespace App\Livewire\Auth;

use App\Traits\WithToast;
use Illuminate\Support\Facades\Auth;
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
        
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->showErrorToast('These credentials do not match our records.');
            return;
        }

        app('UpdateUserService')->execute([
            'user_id' => Auth::user()->id,
            'timezone' => $this->timezone,
            'version' => Auth::user()->version,
        ]);
        
        $this->showSuccessToast('Login successful! Welcome back!');

        $this->dispatch('login-success');
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
