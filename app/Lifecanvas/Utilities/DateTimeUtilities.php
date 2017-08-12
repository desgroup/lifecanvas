<?php

namespace App\Lifecanvas\Utilities;

use Carbon\Carbon;

class DateTimeUtilities
{
    /**
     * @param $utcTime
     * @param $timezoneName
     * @return string|static
     */
    public static function toLocalTime($utcTime, $timezoneName){
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $utcTime);
        $date->setTimezone($timezoneName);
        //$date = $date->format('Y-m-d H:i:s');
        return $date;
    }

    /**
     * @param $localTime
     * @param $timezoneName
     * @return string|static
     */
    public static function toUtcTime($localTime, $timezoneName){
        $date = Carbon::createFromFormat('Y:m:d H:i:s', $localTime, $timezoneName);
        $date->setTimezone('UTC');
        //$date = $date->format('Y-m-d H:i:s');
        return $date;
    }
}