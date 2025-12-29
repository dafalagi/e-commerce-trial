<?php

namespace App\Livewire\Auth;

use App\Traits\WithToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Login extends Component
{
    use WithToast;
    
    #[Rule('required|email')]
    public string $email = '';
    
    #[Rule('required|min:6')]
    public string $password = '';
    
    public bool $remember = false;
    
    public function login()
    {
        $this->validate();
        
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->showErrorToast('These credentials do not match our records.');
            return;
        }
        
        session()->regenerate();
        
        return redirect()->intended(route('products.index'));
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
