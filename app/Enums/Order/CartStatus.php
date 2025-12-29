<?php

namespace App\Enums\Order;

enum CartStatus: string
{
    case ACTIVE = 'active';
    case CHECKED_OUT = 'checked_out';
    case ABANDONED = 'abandoned';

    public static function labels(): array
    {
        return [
            self::ACTIVE->value => 'Active',
            self::CHECKED_OUT->value => 'Checked Out',
            self::ABANDONED->value => 'Abandoned',
        ];
    }
}