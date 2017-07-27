<?php

namespace App\Lifecanvas\Utilities;


class FuzzyDate
{
    private $values = array();
    private $datetime;
    private $accuracy;

    public function makeFormValues($currentDate, $accuracy) {

        // Check year
        $this->values["year"] = (substr( $accuracy, 0, 1 ) == 1 ? date('Y', strtotime($currentDate)) : "");

        // Check month
        $this->values["month"] = (substr( $accuracy, 1, 1 ) == 1 ? date('n', strtotime($currentDate)) : "");

        // Check day
        $this->values["day"] = (substr( $accuracy, 2, 1 ) == 1 ? date('j', strtotime($currentDate)) : "");

        // Check hour
        $this->values["hour"] = (substr( $accuracy, 3, 1 ) == 1 ? date('G', strtotime($currentDate)) : "");

        // Check minute
        $this->values["minute"] = (substr( $accuracy, 4, 1 ) == 1 ? date('i', strtotime($currentDate)) : "");

        // Check seconds
        $this->values["second"] = (substr( $accuracy, 5, 1 ) == 1 ? date('s', strtotime($currentDate)) : "");

        return $this->values;

    }

    public function makeByteDate($year, $month, $day, $hour, $minute, $seconds) {

        // Set year
        if($year != "") {

            $this->datetime = $year;
            $this->accuracy = "1";

        } else {

            $this->datetime = "0000";
            $this->accuracy = "0";

        }

        // Set month
        if($month != "") {

            $this->datetime .= ":" . (strlen($month) == 1 ? "0" . $month : $month);
            $this->accuracy .= "1";

        } else {

            $this->datetime .= ":01";
            $this->accuracy .= "0";

        }

        // Set day
        if($day != "") {

            $this->datetime .= ":" . (strlen($day) == 1 ? "0" . $day : $day);
            $this->accuracy .= "1";

        } else {

            $this->datetime .= ":01";
            $this->accuracy .= "0";

        }

        // Set hour
        if($hour != "") {

            $this->datetime .= " " . (strlen($hour) == 1 ? "0" . $hour : $hour);
            $this->accuracy .= "1";

        } else {

            $this->datetime .= " 00";
            $this->accuracy .= "0";

        }

        // Set minute
        if($minute != "") {

            $this->datetime .= ":" . (strlen($minute) == 1 ? "0" . $minute : $minute);
            $this->accuracy .= "1";

        } else {

            $this->datetime .= ":00";
            $this->accuracy .= "0";

        }

        // Set seconds
        if($seconds != "") {

            $this->datetime .= ":" . (strlen($seconds) == 1 ? "0" . $seconds : $seconds);
            $this->accuracy .= "10";

        } else {

            $this->datetime .= ":00";
            $this->accuracy .= "00";

        }

        return array("datetime" => $this->datetime, "accuracy" => $this->accuracy);

    }
}