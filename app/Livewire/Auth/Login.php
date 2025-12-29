<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Login extends Component
{
    #[Rule('required|email')]
    public string $email = '';
    
    #[Rule('required|min:6')]
    public string $password = '';
    
    public bool $remember = false;
    
    public function login()
    {
        $this->validate();
        
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }
        
        session()->regenerate();
        
        return redirect()->intended(route('products.index'));
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
