<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class NotificationButton extends Component
{
    public $unread_count = 0;

    public function mount()
    {
        $this->loadNotificationCount();
    }

    #[On('notification-count-updated')]
    public function updateNotificationCount($count)
    {
        $this->unread_count = $count;
    }

    #[On('notification-updated')]
    public function loadNotificationCount()
    {
        if (!Auth::check()) {
            $this->unread_count = 0;
            return;
        }

        try {
            $result = app('GetNotificationService')->execute([
                'user_uuid' => Auth::user()->uuid,
                'is_read' => false,
                'count_only' => true
            ], true);

            $this->unread_count = $result['data']->count() ?? 0;
        } catch (\Exception $e) {
            $this->unread_count = 0;
        }
    }

    public function openNotifications()
    {
        $this->dispatch('toggle-notification-modal');
    }

    public function render()
    {
        return view('livewire.components.notification-button');
    }
}