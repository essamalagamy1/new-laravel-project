<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Payment Status - Financial state of the order
 */
final class PaymentStatus extends Enum
{
    const Pending = 'pending';

    const Paid = 'paid';

    const Failed = 'failed';

    const Expired = 'expired';

    const Refunded = 'refunded';

    public function title(): string
    {
        return match ($this->value) {
            self::Pending => __('lang.payment_pending'),
            self::Paid => __('lang.payment_paid'),
            self::Failed => __('lang.payment_failed'),
            self::Expired => __('lang.payment_expired'),
            self::Refunded => __('lang.payment_refunded'),
            default => 'Unknown',
        };
    }

    public function color(): string
    {
        return match ($this->value) {
            self::Pending => 'yellow-500',
            self::Paid => 'green-500',
            self::Failed => 'red-500',
            self::Expired => 'gray-500',
            self::Refunded => 'orange-500',
            default => 'gray-500',
        };
    }
}
