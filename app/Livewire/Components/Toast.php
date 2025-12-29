<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Toast extends Component
{
    public $messages = [];
    
    protected $listeners = ['showToast'];
    
    public function showToast($type, $message)
    {
        $this->messages[] = [
            'id' => uniqid(),
            'type' => $type,
            'message' => $message,
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
