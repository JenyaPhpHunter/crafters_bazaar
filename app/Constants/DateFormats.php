<?php

namespace App\Constants;

use Illuminate\Support\Carbon;
use DateTime;
use Illuminate\Support\Facades\Log;

class DateFormats
{
    const DB_DATE_FORMAT = 'Y-m-d H:i:s';
    const DB_DATE_ONLY_FORMAT = 'Y-m-d';
    const UI_DATE_FORMAT = 'd-m-Y H:i:s';
    const UI_DATE_EUR_FORMAT = 'd.m.Y H:i:s';
    const UI_DATE_ONLY_FORMAT = 'd-m-Y';
    const UI_DATE_ONLY_DOT_DIVIDER_FORMAT = 'd.m.Y';
    const UI_DATE_SHORT_DOT_DIVIDER_FORMAT = 'd.m.y';
    const UI_TIME_ONLY_FORMAT = 'H:i:s';
    const DATE_FOR_FILENAMES = 'Ymd';
    const MILISEC_FOR_FILENAMES = 'YmdHisv';
    const MICROSEC_FOR_FILENAMES = 'YmdHisu';

    public static function gatCarbonFromDate($date)
    {
        if ($date instanceof Carbon) {
            return $date;
        }

        if (is_string($date)) {
            try {
                $date = Carbon::parse($date);
            } catch (\Exception $e) {
                Log::error($e->getTrace());
                throw new InvalidArgumentException(UserAndLogMessages::ERROR_INCORRECT_DATA);
            }
        }

        if ($date instanceof DateTime) {
            $date = Carbon::instance($date);
        } else {
            Log::error(gettype($date) . ' ' . UserAndLogMessages::ERROR_INCORRECT_DATA);
            throw new InvalidArgumentException(UserAndLogMessages::ERROR_INCORRECT_DATA);
        }

        return $date;
    }
}
