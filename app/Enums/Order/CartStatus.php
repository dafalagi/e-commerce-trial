<?php

namespace App\Enums\Order;

enum CartStatus: string
{
    case ACTIVE = 'active';
    case CHECKED_OUT = 'checked_out';

    public static function labels(): array
    {
        return [
            self::ACTIVE->value => 'Active',
            self::CHECKED_OUT->value => 'Checked Out',
        ];
    }
}