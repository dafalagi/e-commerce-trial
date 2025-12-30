<?php

namespace App\Livewire\Components;

use App\Traits\WithToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class NotificationModal extends Component
{
    use WithToast;

    public $is_open = false;
    public $notifications;
    public $grouped_notifications = [];
    public $unread_count = 0;

    public function mount()
    {
        $this->loadNotifications();
    }

    #[On('toggle-notification-modal')]
    public function toggleModal()
    {
        $this->is_open = !$this->is_open;
        
        if ($this->is_open) {
            $this->loadNotifications();
        }
    }

    public function closeModal()
    {
        $this->is_open = false;
    }

    #[On('notification-updated')]
    public function loadNotifications()
    {
        if (!Auth::check()) {
            $this->notifications = collect();
            $this->grouped_notifications = [];
            $this->unread_count = 0;
            return;
        }

        try {
            $this->notifications = app('GetNotificationService')->execute([
                'user_uuid' => Auth::user()->uuid,
                'is_read' => false,
                'sort_by' => 'created_at',
                'sort_type' => 'desc',
                'per_page' => 50,
                'with_pagination' => true
            ], true)['data'];

            $this->unread_count = $this->notifications->count();
            $this->groupNotificationsByDate();

            $this->dispatch('notification-count-updated', count: $this->unread_count);
        } catch (\Exception $e) {
            $this->notifications = collect();
            $this->grouped_notifications = [];
            $this->unread_count = 0;
        }
    }

    public function markAsRead($notification_uuid)
    {
        DB::beginTransaction();
        try {
            $notification = $this->notifications->firstWhere('uuid', $notification_uuid);
            
            if ($notification) {
                app('UpdateNotificationService')->execute([
                    'notification_uuid' => $notification_uuid,
                    'is_read' => true,
                    'version' => $notification->version
                ], true);

                $this->loadNotifications();
                $this->showSuccessToast('Notification marked as read!');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->showErrorToast('Failed to mark notification as read. Please try again.');
        }
    }

    public function markAllAsRead()
    {
        DB::beginTransaction();
        try {
            foreach ($this->notifications as $notification) {
                app('UpdateNotificationService')->execute([
                    'notification_uuid' => $notification->uuid,
                    'is_read' => true,
                    'version' => $notification->version
                ], true);
            }

            $this->loadNotifications();
            $this->showSuccessToast('All notifications marked as read!');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->showErrorToast('Failed to mark notifications as read. Please try again.');
        }
    }

    private function groupNotificationsByDate()
    {
        $this->grouped_notifications = $this->notifications->groupBy(function ($notification) {
            $date = $notification->created_at->format('Y-m-d');
            $today = date('Y-m-d');
            $yesterday = date('Y-m-d', strtotime('-1 day'));

            if ($date === $today) {
                return 'Today';
            } elseif ($date === $yesterday) {
                return 'Yesterday';
            } else {
                return $notification->created_at->format('F j, Y');
            }
        })->all();
    }

    public function render()
    {
        return view('livewire.components.notification-modal');
    }
}