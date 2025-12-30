<?php

namespace App\Jobs;

use App\Enums\Notification\NotificationType;
use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Broadcast;

class SendLowStockNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user_uuid;
    public $product_id;
    public $product_name;
    public $stock_level;

    /**
     * Create a new job instance.
     */
    public function __construct($user_uuid, $product_id, $product_name, $stock_level)
    {
        $this->user_uuid = $user_uuid;
        $this->product_id = $product_id;
        $this->product_name = $product_name;
        $this->stock_level = $stock_level;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::where('uuid', $this->user_uuid)->first();
        
        if (!$user) return;

        $notification = app('StoreNotificationService')->execute([
            'user_uuid' => $this->user_uuid,
            'title' => 'Low Stock Alert',
            'message' => "Product '{$this->product_name}' is running low on stock. Current stock: {$this->stock_level} units.",
            'type' => NotificationType::WARNING->value,
            // 'payload' => [
            //     'product_id' => $this->product_id,
            //     'product_name' => $this->product_name,
            //     'stock_level' => $this->stock_level
            // ]
        ])['data'];

        // Broadcast::on('user.' . $this->user_uuid)
        //     ->with([
        //         'type' => 'low_stock_alert',
        //         'notification' => [
        //             'id' => $notification->id,
        //             'title' => $notification->title,
        //             'message' => $notification->message,
        //             'created_at' => $notification->created_at->toISOString(),
        //             'is_read' => false
        //         ]
        //     ])
        //     ->send();
    }
}