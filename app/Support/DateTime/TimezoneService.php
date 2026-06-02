<?php

declare(strict_types=1);

namespace App\Support\DateTime;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Auth\Authenticatable;

class TimezoneService
{
    private const DEFAULT_TIMEZONE = 'UTC';

    /**
     * تحويل أي تاريخ إلى توقيت المستخدم المحلي.
     */
    public function toUserTime(
        string|CarbonInterface|null $date,
        ?Authenticatable $user = null,
        ?string $fallbackTimezone = null
    ): ?CarbonImmutable {
        if (! $date) {
            return null;
        }

        $parsedDate = $this->parseToImmutable($date);
        $timezone = $this->resolveTimezone($user, $fallbackTimezone);

        return $parsedDate->setTimezone($timezone);
    }

    /**
     * استقبال تاريخ من المستخدم (بناءً على توقيته) وتحويله فوراً لـ UTC للتخزين.
     */
    public function parseUserDateToUtc(
        string $dateString,
        ?Authenticatable $user = null,
        ?string $fallbackTimezone = null
    ): CarbonImmutable {
        $timezone = $this->resolveTimezone($user, $fallbackTimezone);

        // نقرأ التاريخ كأنه في منطقة المستخدم الزمنية، ثم نحوله إلى UTC
        return CarbonImmutable::parse($dateString, $timezone)->setTimezone('UTC')->utc();
    }

    /**
     * تنسيق التاريخ بطريقة Localization-aware
     */
    public function format(
        string|CarbonInterface|null $date,
        bool $withTime = false,
        ?Authenticatable $user = null
    ): ?string {
        $userTime = $this->toUserTime($date, $user);

        if (! $userTime) {
            return null;
        }

        $format = $withTime ? 'd/m/Y h:i A' : 'd M Y';

        return $userTime->translatedFormat($format);
    }

    /**
     * ضمان أننا نتعامل مع CarbonImmutable لمنع الطفرات (Mutations)
     */
    private function parseToImmutable(string|CarbonInterface $date): CarbonImmutable
    {
        if ($date instanceof CarbonImmutable) {
            return $date;
        }

        return CarbonImmutable::parse($date);
    }

    /**
     * تحديد الـ Timezone بأولوية واضحة
     */
    private function resolveTimezone(?Authenticatable $user, ?string $fallback = null): string
    {
        if ($user && ! empty($user->timezone)) {
            return $user->timezone;
        }

        if ($fallback) {
            return $fallback;
        }

        // Guess from IP for Guest or missing TZ
        $ipTimezone = getTimezoneByIP(request()->ip());

        return $ipTimezone ?: config('app.timezone', self::DEFAULT_TIMEZONE);
    }
}
