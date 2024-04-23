<?php

namespace App\Service;

use DateTime;
use DateTimeZone;

class TimeCountService
{
    /**
     * @param string $inputTimezone
     * @return string|null
     */
    public function OffsetInMinutes(string $inputTimezone): ?string
    {
        $timezone = new DateTimeZone($inputTimezone);
        $offsetSeconds = $timezone->getOffset(new DateTime());
        $offsetMinutes = $offsetSeconds / 60;

        return $offsetMinutes > 0 ? '+' . $offsetMinutes : $offsetMinutes;
    }

    /**
     * @param string $inputDate
     * @return string|null
     */
    public function FebruaryLength(string $inputDate): ?int
    {
        $currentYear = (int) date($inputDate);
        $february = new DateTime("$currentYear-02-01");

        return (int) $february->format('t');
    }
}
