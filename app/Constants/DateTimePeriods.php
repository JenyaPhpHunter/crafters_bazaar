<?php

/**
 * DateTimePeriods.php
 * @package Show currency pairs
 * @version 1.0.0
 * @link
 * PERIODS - array of available periods
 */
namespace App\Constants;

use DateTime;

class DateTimePeriods
{
    const S5 = 5;
    const S10 = 10;
    const S15 = 15;
    const S30 = 30;
    const M1 = 60;
    const M2 = 120;
    const M3 = 180;
    const M5 = 300;
    const M10 = 600;
    const M15 = 900;
    const M30 = 1800;
    const H1 = 3600;
    const H2 = 7200;
    const H4 = 14400;
    const H6 = 21600;
    const D1 = 86400;
    const D2 = 172800;
    const D3 = 259200;
    const D10 = 864000;
    const W1 = 604800;
    const W2 = 1209600;
    const MN1 = 2592000;
    const MN3 = 7776000;
    const Y1 = 31536000;
    const InMin1 = 1;
    const InMin5 = 5;
    const InMin10 = 10;
    const InMin15 = 15;
    const InMin30 = 30;
    const InMinH = 60;
    const InMinH4 = 240;
    const InMinH6 = 360;
    const InMinH8 = 480;
    const InMinD = 1440;

    const StartOfPeriod = [
        "Minute" => 'Y-m-d H:i:00',
        "Hour" => 'Y-m-d H:00:00',
        "Day" => 'Y-m-d 00:00:00',
        "W1" => 'o-\WW-1 00:00:00',
        "Month" => 'Y-m-01 00:00:00',
        "Year" => 'Y-01-01 00:00:00',
    ];
    const EndOfPeriod = [
        "Minute" => 'Y-m-d H:i:59',
        "Hour" => 'Y-m-d H:59:59',
        "Day" => 'Y-m-d 23:59:59',
        "W1" => 'o-\WW-7 23:59:59',
        "Month" => 'Y-m-t 23:59:59',
        "Year" => 'Y-12-31 23:59:59',
    ];

    const StartOfPeriodEur = [
        "Minute" => 'd.m.Y H:i:00',
        "Hour" => 'd.m.Y H:00:00',
        "Day" => 'd.m.Y 00:00:00',
        "W1" => 'last monday',
        "Month" => 'first day of this month 00:00:00',
    ];

    const EndOfPeriodEur = [
        "Minute" => 'd.m.Y H:i:59',
        "Hour" => 'd.m.Y H:59:59',
        "Day" => 'd.m.Y 23:59:59',
        "W1" => 'next sunday 23:59:59',
        "Month" => 'last day of this month 23:59:59',
    ];

    public static function toTimeStamp($time): int
    {
        if (is_string($time)) {
            $time = strtotime($time);
        } elseif ($time instanceof DateTime) {
            $time = $time->getTimestamp();
        }
        return $time;
    }

    public static function getStartOfPeriod($time, string $period = "Day", $toCarbone = true, $offset = null): DateTime
    {
        $time = self::toTimeStamp($time);

        if (!is_null($offset)) {
            $offset = self::toTimeStamp($offset);
            $time += $offset;
        }
        $result = date(self::StartOfPeriod[$period], $time);
        return $toCarbone ? DateFormats::gatCarbonFromDate($result) : new DateTime($result);
    }

    public static function getEndOfPeriod($time, string $period = "Day", $toCarbone = true, $offset = null): DateTime
    {
        $time = self::toTimeStamp($time);
        if (!is_null($offset)) {
            $offset = self::toTimeStamp($offset);
            $time += $offset;
        }
        $result = date(self::EndOfPeriod[$period], $time);
        return $toCarbone ? DateFormats::gatCarbonFromDate($result) : new DateTime($result);
    }

    public static function getFormatedDiff($diff, DateTime $currentDateTime = null)
    {
        $currentDateTime = $currentDateTime ?? new DateTime();
        if (is_integer($diff) && $diff > 0) {
            $diff = date(DateFormats::UI_DATE_FORMAT, $diff);
        } elseif (is_string($diff)) {
            $diff = date(DateFormats::UI_DATE_FORMAT, strtotime($diff));
        }

        $startPeriodFormated = DateTime::createFromFormat(DateFormats::UI_DATE_FORMAT, $diff);
        $difference = $currentDateTime->diff($startPeriodFormated);
        $month_txt =  '';
        $days_txt =  '';
        $hours_txt =  '';
        $minutes_txt =  '';
        $seconds_txt =  '';
        if (isset($difference->m)) {
            $last_digit = $difference->m % 10;
            $last_two_digits = $difference->m % 100;

            if ($last_digit === 1 && $last_two_digits !== 11) {
                $month_txt =  "місяць";
            } elseif ($last_digit >= 2 && $last_digit <= 4 && !($last_two_digits >= 12 && $last_two_digits <= 14)) {
                $month_txt =  "місяці";
            } else {
                $month_txt = "місяців";
            }
        }
        if (isset($difference->d)) {
            $last_digit = $difference->d % 10;
            $last_two_digits = $difference->d % 100;

            if ($last_digit === 1 && $last_two_digits !== 11) {
                $days_txt =  "день";
            } elseif ($last_digit >= 2 && $last_digit <= 4 && !($last_two_digits >= 12 && $last_two_digits <= 14)) {
                $days_txt =  "дні";
            } else {
                $days_txt = "днів";
            }
        }
        if (isset($difference->h)) {
            $last_digit = $difference->h % 10;
            $last_two_digits = $difference->h % 100;

            if ($last_digit === 1 && $last_two_digits !== 11) {
                $hours_txt =  "година";
            } elseif ($last_digit >= 2 && $last_digit <= 4 && !($last_two_digits >= 12 && $last_two_digits <= 14)) {
                $hours_txt =  "години";
            } else {
                $hours_txt = "годин";
            }
        }
        if (isset($difference->i)) {
            $last_digit = $difference->i % 10;
            $last_two_digits = $difference->i % 100;

            if ($last_digit === 1 && $last_two_digits !== 11) {
                $minutes_txt =  "хвилина";
            } elseif ($last_digit >= 2 && $last_digit <= 4 && !($last_two_digits >= 12 && $last_two_digits <= 14)) {
                $minutes_txt =  "хвилини";
            } else {
                $minutes_txt = "хвилин";
            }
        }
        if (isset($difference->s)) {
            $last_digit = $difference->s % 10;
            $last_two_digits = $difference->s % 100;

            if ($last_digit === 1 && $last_two_digits !== 11) {
                $seconds_txt =  "секунда";
            } elseif ($last_digit >= 2 && $last_digit <= 4 && !($last_two_digits >= 12 && $last_two_digits <= 14)) {
                $seconds_txt =  "секунди";
            } else {
                $seconds_txt = "секунд";
            }
        }
        $diffOutput = [
            $difference->m ? $difference->m . ' ' . $month_txt : null,
            $difference->d ? $difference->d . ' ' . $days_txt : null,
            $difference->h ? $difference->h . ' ' . $hours_txt : null,
            $difference->i ? $difference->i . ' ' . $minutes_txt : null,
            $difference->s ? $difference->s . ' ' . $seconds_txt : null,
        ];
        return implode(', ', array_filter($diffOutput));
    }
}
