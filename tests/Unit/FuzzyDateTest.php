<?php

namespace Tests\Unit;

use App\Lifecanvas\Utilities\FuzzyDate;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use TimezonesTableSeeder;

class FuzzyDateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function returns_an_array_of_datetime_values_reflecting_a_given_accuracy()
    {
        $fuzzyDate = new FuzzyDate();
        $date = Carbon::now();

        $accuracyArray = [
            '011111',
            '101111',
            '110111',
            '111011',
            '111101'
        ];

        $elementsArray = [
            'year',
            'month',
            'day',
            'hour',
            'minute',
            'second'
        ];

        for($x = 0; $x <= 4; $x++){

            $result = $fuzzyDate->makeFormValues($date, $accuracyArray[$x]);

            foreach ($elementsArray as $datetime) {
                if($datetime == $elementsArray[$x]) {
                    $this->assertEquals($result[$datetime], "");
                } else {
                    $this->assertEquals($result[$datetime], $date->$datetime);
                }
            }
        }
    }

    /** @test */
    function creates_a_timestamp_from_form_input_values()
    {
        // TODO-KGW Change to use a response object, not a set of parameters

        $formValues = [
            'year' => 1966,
            'month' => 10,
            'day' => 22,
            'hour' => 22,
            'minute' => 00,
            'second' => 00
        ];

        $fuzzyDate = new FuzzyDate();
        $timestamp = $fuzzyDate->makeByteDate(
            $formValues['year'],
            $formValues['month'],
            $formValues['day'],
            $formValues['hour'],
            $formValues['minute'],
            $formValues['second']
        );

        $this->assertEquals($timestamp['datetime'], '1966:10:22 22:00:00');
    }

    /** @test */
    function returns_array_with_timestamp_and_accuracy_from_form_submission()
    {
        $seeder = new TimezonesTableSeeder();
        $seeder->run();

        $request = new Request();

        $request->replace([
            'year' => '1966',
            'month' => '10',
            'day' => '22',
            'hour' => '22',
            'minute' => '00',
            'second' => '00'
        ]);

        $result = FuzzyDate::createTimestamp($request);

        $this->assertEquals('1966:10:22 22:00:00', $result['datetime']);
        $this->assertEquals('111111', $result['accuracy']);
    }
}
