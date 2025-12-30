<?php

namespace App\Enums\Notification;

enum NotificationType: string
{
    case INFO = 'info';
    case WARNING = 'warning';

    public function label(): string
    {
        return match($this) {
            self::INFO => 'Info',
            self::WARNING => 'Warning',
        };
    }
}