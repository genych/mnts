<?php declare(strict_types=1);

namespace App\Util;

class Converter
{
    public static function fromMinorUnits(?int $amount): string
    {
        return sprintf("%.2f", round((int)$amount / 100, 2));
    }
    
    public static function toMinorUnits($amount): ?int
    {
        if (!is_numeric($amount)) {
            return null;
        }

        $amount = (float)$amount;

        if ($amount < 0) {
            return null;
        }

// TODO: weird cases
        return (int)round($amount * 100);
    }

}
