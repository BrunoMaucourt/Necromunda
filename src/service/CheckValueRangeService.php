<?php

namespace App\service;

class CheckValueRangeService
{
    public function isBetweenOrEqual(string $range, int $valueToCkech): bool
    {
        list($lower, $upper) = explode('-', $range);

        $lower = (int)$lower;
        $upper = (int)$upper;

        return $valueToCkech >= $lower && $valueToCkech <= $upper;
    }
}