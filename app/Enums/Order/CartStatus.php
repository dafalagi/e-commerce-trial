<?php

namespace App\Enums\Order;

enum CartStatus: string
{
    case ACTIVE = 'active';
    case CHECKED_OUT = 'checked_out';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::CHECKED_OUT => 'Checked Out',
        };
    }
}