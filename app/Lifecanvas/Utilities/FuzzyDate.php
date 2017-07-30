<?php

namespace App\Lifecanvas\Utilities;


use App\Timezone;
use Carbon\Carbon;

class FuzzyDate
{
    private $values = array();
    private $datetime;
    private $accuracy;

    public static function createTimestamp($request, $image_date = null)
    {
        if (is_null($image_date)) {

            $fuzzy_date = new FuzzyDate();

            $byte_date = $fuzzy_date->makeByteDate(
                $request->year,
                $request->month,
                $request->day,
                $request->hour,
                $request->minute,
                $request->second
            );

        } else {

            $byte_date = array("datetime" => $image_date['datetime'],
                "accuracy" => $image_date['accuracy']);
        }

        if (!is_null($request->timezone_id) && $request->timezone_id <> "00") {
            $timeZone = Timezone::where('id', '=', $request->timezone_id)->first();
        } elseif (!is_null($request->usertimezone)) {
            $timeZone = Timezone::where('timezone_name', '=', $request->usertimezone)->first();
        } else {
            $timeZone = Timezone::where('id', '=', 371)->first();
        }

        $byte_date["datetime"] = $timestamp = Carbon::createFromFormat('Y:m:d H:i:s',
            $byte_date["datetime"], $timeZone->timezone_name);

        return $byte_date;
    }

    public function makeFormValues($currentDate, $accuracy)
    {

        // Check year
        $this->values["year"] = (substr($accuracy, 0, 1) == 1 ? date('Y', strtotime($currentDate)) : "");

        // Check month
        $this->values["month"] = (substr($accuracy, 1, 1) == 1 ? date('n', strtotime($currentDate)) : "");

        // Check day
        $this->values["day"] = (substr($accuracy, 2, 1) == 1 ? date('j', strtotime($currentDate)) : "");

        // Check hour
        $this->values["hour"] = (substr($accuracy, 3, 1) == 1 ? date('G', strtotime($currentDate)) : "");

        // Check minute
        $this->values["minute"] = (substr($accuracy, 4, 1) == 1 ? date('i', strtotime($currentDate)) : "");

        // Check seconds
        $this->values["second"] = (substr($accuracy, 5, 1) == 1 ? date('s', strtotime($currentDate)) : "");

        return $this->values;

    }

    public function makeByteDate($year, $month, $day, $hour, $minute, $second)
    {

        // Set year
        if ($year != "") {

            $this->datetime = $year;
            $this->accuracy = "1";

        } else {

            $this->datetime = "0000";
            $this->accuracy = "0";

        }

        // Set month
        if ($month != "") {

            $this->datetime .= ":" . (strlen($month) == 1 ? "0" . $month : $month);
            $this->accuracy .= "1";

        } else {

            $this->datetime .= ":01";
            $this->accuracy .= "0";

        }

        // Set day
        if ($day != "") {

            $this->datetime .= ":" . (strlen($day) == 1 ? "0" . $day : $day);
            $this->accuracy .= "1";

        } else {

            $this->datetime .= ":01";
            $this->accuracy .= "0";

        }

        // Set hour
        if ($hour != "") {

            $this->datetime .= " " . (strlen($hour) == 1 ? "0" . $hour : $hour);
            $this->accuracy .= "1";

        } else {

            $this->datetime .= " 00";
            $this->accuracy .= "0";

        }

        // Set minute
        if ($minute != "") {

            $this->datetime .= ":" . (strlen($minute) == 1 ? "0" . $minute : $minute);
            $this->accuracy .= "1";

        } else {

            $this->datetime .= ":00";
            $this->accuracy .= "0";

        }

        // Set seconds
        if ($second != "") {

            $this->datetime .= ":" . (strlen($second) == 1 ? "0" . $second : $second);
            $this->accuracy .= "1";

        } else {

            $this->datetime .= ":00";
            $this->accuracy .= "0";

        }
        return array("datetime" => $this->datetime, "accuracy" => $this->accuracy);
    }
}