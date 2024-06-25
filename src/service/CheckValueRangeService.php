<?php

namespace App\service;

class CheckValueRangeService
{
    public function isBetweenOrEqual(string $range, int $valueToCkech): bool
    {
        $rangeArray = explode(',', $range);
        foreach ($rangeArray as $range) {
            list($lower, $upper) = explode('-', $range);

            $lower = (int)$lower;
            $upper = (int)$upper;

            if ($valueToCkech >= $lower && $valueToCkech <= $upper) {
                return true;
            }
        }

        return false;
    }
}