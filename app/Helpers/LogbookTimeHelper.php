<?php

namespace App\Helpers;

class LogbookTimeHelper
{
    public static function formatActivityDateTime($value, $withTime = true): array
    {
        if (empty($value)) {
            return ['date' => '-', 'time' => ''];
        }

        $dateTime = self::normalizeToWib($value);

        if (!$dateTime) {
            return ['date' => '-', 'time' => ''];
        }

        $dateTime = $dateTime->setTimezone(new \DateTimeZone('Asia/Jakarta'));
        $date = $dateTime->format('d M Y');
        $time = '';

        if ($withTime && self::hasTimeComponent($value)) {
            $time = $dateTime->format('H:i');
        }

        return ['date' => $date, 'time' => $time];
    }

    public static function formatActivityDateTimeLabel($value): string
    {
        $formatted = self::formatActivityDateTime($value);

        return $formatted['date'] . ($formatted['time'] !== '' ? "\n" . $formatted['time'] : '');
    }

    public static function getServerNow($format = 'Y-m-d H:i:s'): string
    {
        return (new \DateTime('now', new \DateTimeZone('Asia/Jakarta')))->format($format);
    }

    private static function normalizeToWib($value): ?\DateTime
    {
        if ($value instanceof \DateTimeInterface) {
            $dateTime = new \DateTime($value->format('Y-m-d H:i:s'), new \DateTimeZone('Asia/Jakarta'));
            return $dateTime;
        }

        if (is_string($value)) {
            $trimmed = trim($value);
            if ($trimmed === '') {
                return null;
            }

            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $trimmed)) {
                return new \DateTime($trimmed . ' 00:00:00', new \DateTimeZone('Asia/Jakarta'));
            }

            $dateTime = new \DateTime($trimmed, new \DateTimeZone('Asia/Jakarta'));
            if ($dateTime !== false) {
                return $dateTime;
            }
        }

        return null;
    }

    private static function hasTimeComponent($value): bool
    {
        if ($value instanceof \DateTimeInterface) {
            return true;
        }

        if (!is_string($value)) {
            return false;
        }

        $trimmed = trim($value);

        return preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}(:\d{2})?$/', $trimmed) === 1;
    }
}
