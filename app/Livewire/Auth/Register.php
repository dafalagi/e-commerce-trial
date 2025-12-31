<?php

namespace App\Livewire\Auth;

use App\Traits\WithToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Register extends Component
{
    use WithToast;
    
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $timezone = '';
    public $is_loading = false;
    public $user;

    protected $rules = [
        'email' => ['required', 'email', 'unique:auth_users,email'],
    ];

    protected $messages = [
        'email.unique' => 'An account with this email address already exists.',
    ];

    public function register()
    {
        $this->validate();
        
        $this->is_loading = true;

        DB::beginTransaction();
        try {
            $customer_role = \App\Models\Auth\Role::where('code', 'customer')->first();
            
            if (!$customer_role) {
                throw new \Exception('Customer role not found. Please contact support.');
            }

            $this->user = app('CreateUserService')->execute([
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'timezone' => $this->timezone ?: 'UTC',
                'role_uuid' => $customer_role->uuid,
            ], true)['data'];

            $this->showSuccessToast('Account created successfully! Welcome aboard!');
            
            DB::commit();
            
            $this->dispatch('register-success');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->showErrorToast($e->getMessage());
        } finally {
            $this->is_loading = false;
        }
    }

    public function redirectToProducts()
    {
        Auth::login($this->user, true);
        session()->regenerate();

        $this->redirect(route('products.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}