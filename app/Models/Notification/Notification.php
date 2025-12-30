<?php

namespace App\Models\Notification;

use App\Enums\Notification\NotificationType;
use App\Models\Auth\User;
use App\Models\BaseModel;

class Notification extends BaseModel
{
    protected $table = 'ntf_notifications';

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:U',
            'updated_at' => 'datetime:U',
            'deleted_at' => 'datetime:U',

            'type' => NotificationType::class,
            'payload' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
