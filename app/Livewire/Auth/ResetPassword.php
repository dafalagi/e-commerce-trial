<?php

namespace App\Livewire\Auth;

use App\Traits\WithToast;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ResetPassword extends Component
{
    use WithToast;

    public $token;
    public $email;
    public $password = '';
    public $password_confirmation = '';
    public $is_loading = false;

    protected $rules = [
        'email' => ['required', 'email', 'exists:auth_users,email'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];

    protected $messages = [
        'email.exists' => 'We could not find a user with that email address.',
    ];

    public function mount($token = null)
    {
        $this->token = $token ?? request('token');
        $this->email = request('email', '');
        
        if (!$this->token) {
            $this->showErrorToast('Invalid or expired reset token.');
            return $this->redirect(route('login'), navigate: true);
        }
    }

    public function resetPassword()
    {
        $this->validate();
        
        $this->is_loading = true;

        DB::beginTransaction();
        try {
            $result = app('ResetPasswordService')->execute([
                'token' => $this->token,
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ], true);

            $this->showSuccessToast($result['message']);

            DB::commit();
            
            return $this->redirect(route('login'), navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->showErrorToast($e->getMessage());
        } finally {
            $this->is_loading = false;
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}