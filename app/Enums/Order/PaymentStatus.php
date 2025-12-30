<?php

namespace App\Enums\Order;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case FAILED = 'failed';

    public static function labels(): array
    {
        return [
            self::PENDING->value => 'Pending',
            self::PAID->value => 'Paid',
            self::FAILED->value => 'Failed',
        ];
    }
}