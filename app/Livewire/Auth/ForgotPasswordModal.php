<?php

namespace App\Livewire\Auth;

use App\Traits\WithToast;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class ForgotPasswordModal extends Component
{
    use WithToast;

    public $is_open = false;
    public $email = '';
    public $is_loading = false;

    protected $rules = [
        'email' => ['required', 'email', 'exists:auth_users,email']
    ];

    protected $messages = [
        'email.exists' => 'We could not find a user with that email address.'
    ];

    #[On('open-forgot-password')]
    public function openModal()
    {
        $this->is_open = true;
        $this->reset(['email', 'is_loading']);
        $this->resetErrorBag();
    }

    public function closeModal()
    {
        $this->is_open = false;
        $this->reset(['email', 'is_loading']);
        $this->resetErrorBag();
    }

    public function sendResetLink()
    {
        $this->validate();
        
        $this->is_loading = true;

        DB::beginTransaction();
        try {
            $result = app('ForgotPasswordService')->execute([
                'email' => $this->email
            ], true);

            $this->showSuccessToast($result['message']);
            $this->closeModal();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->showErrorToast($e->getMessage());
        } finally {
            $this->is_loading = false;
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password-modal');
    }
}