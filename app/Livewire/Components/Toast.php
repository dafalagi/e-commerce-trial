<?php

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class Toast extends Component
{
    public $messages = [];
    
    #[On('showToast')]
    public function showToast($type, $message, $duration = null)
    {
        $this->messages[] = [
            'id' => uniqid(),
            'type' => $type,
            'message' => $message,
            'duration' => $duration ?? 2000,
        ];
    }
    
    public function removeToast($id)
    {
        $this->messages = array_filter($this->messages, fn($msg) => $msg['id'] !== $id);
    }

    public function render()
    {
        return view('livewire.components.toast');
    }
}
