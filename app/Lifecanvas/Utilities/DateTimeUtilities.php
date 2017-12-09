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

    public static function formatFullDate($date, $accuracy) {

        switch ($accuracy) {
            case '111111':
                $displayDate = $date->format('l jS \\of F Y g:i:s A');
                break;
            case '111110':
                $displayDate = $date->format('l jS \\of F Y g:i A');
                break;
            case '111100':
                $displayDate = $date->format('l jS \\of F Y g A');
                break;
            case '111000':
                $displayDate = $date->format('l jS \\of F Y');
                break;
            case '110000':
                $displayDate = $date->format('F Y');
                break;
            case '100000':
                $displayDate = 'Year: ' . $date->format('Y');
                break;
            case '000000':
                $displayDate = 'Unspecified date';
                break;
        }

        return $displayDate;
    }
}