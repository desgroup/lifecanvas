<?php

namespace App\Lifecanvas\Utilities;


use App\Asset;
use App\Timezone;
use Illuminate\Http\Request;
use Image;
//use Intervention\Image\Facades\Image;
//use Intervention\Image\Image;

class ImageUtilities
{
    public function processImage($file)
    {

        // Gather file information to store uploaded file to server with unique file name
        $info = new \SplFileInfo($file->getClientOriginalName());
        $extension = strtolower ($info->getExtension());
        $filename = uniqid(auth()->id(), true);
        $filename = str_replace(".","-",$filename) . "." . $extension;
        $filePath = public_path() . '/usr/'. auth()->id();
        if (!is_dir($filePath . '/org')) {
            mkdir($filePath . '/org', 0777, true);
        }
        $file->move($filePath . '/org/', $filename);

        // Grab the original image to use for the data it contains.
        $img = Image::make($filePath . '/org/' . $filename);

        // Create different versions of the image at different sizes
        $image_sets = [
            ['dir' => '/medium', 'width' => 1500, 'qual' => 90],
            ['dir' => '/small', 'width' => 240, 'qual' => 90],
            ['dir' => '/thumb', 'width' => 125, 'qual' => 70],
        ];

        foreach ($image_sets as $image_set) {
            $path = $filePath . $image_set['dir'];

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $img->resize($image_set['width'], null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path . '/' . $filename, $image_set['qual']);
        }

        // Set key exif variables to null to be overwritten if available
        $size = null;
        $height = null;
        $width = null;
        $date = null;
        $lat = null;
        $lng = null;

        try {
            // Grab exif data from file if jpg or tiff
            if ($exif = exif_read_data($filePath . '/org/' . $filename)) {
                //$exif = exif_read_data($filePath . '/org/' . $filename);

                $size = array_key_exists('GPSLongitude', $exif) ? $exif['FileSize'] / 1000 : NULL;
                $height = $exif['COMPUTED']['Height'] ?? NULL;
                $width = $exif['COMPUTED']['Width'] ?? NULL;
                $date = $exif['DateTime'] ?? NULL;

                // Build longitude and latitude data if available
                if (array_key_exists('GPSLongitude', $exif)) {
                    $lat = $this->getGps($exif['GPSLatitude'], $exif['GPSLatitudeRef']);
                    $lng = $this->getGps($exif['GPSLongitude'], $exif['GPSLongitudeRef']);

                    if ($this->urlExists('https://maps.googleapis.com')) {
                        $timezoneInfo = json_decode(
                            file_get_contents(
                                "https://maps.googleapis.com/maps/api/timezone/json?location=$lat,$lng&timestamp=1458000000&key=AIzaSyAAegLHNSxBaOM-V_4tM1Uuq_S8Atr2t1c")
                            , true);
                        $timezone = Timezone::where('timezone_name', '=', $timezoneInfo['timeZoneId'])->first();
                    }
                }
            }
        } catch (Exception $e) {
            //
        }

        $image_data = array(
            'file_name'         => $filename,
            'extension'         => $extension,
            'size_kb'           => $size,
            'height_px'         => $height,
            'width_px'          => $width,
            'asset_date_local'  => $date,
            'timezone_id'       => !isset($timezone) ? null : $timezone->id,
            'lat'               => $lat,
            'lng'               => $lng,
            'user_id'           => auth()->id()
        );

        $image = Asset::create($image_data);
        //dd($image);

//        if($imageTime == "on" && !is_null($img->exif('DateTime'))) {
//
//            $byte_date = array("datetime" => $img->exif('DateTime'), "accuracy" => "111111");
//            $data = array("id" => $image->id, "byte_date" => $byte_date);
//
//        } else {
//
//            $data = array("id" => $image->id, "byte_date" => null);
//
//        }

        return($image);
    }

//    private function createTimestamp($request, $image_date = null) {
//
//        if(is_null($image_date)) {
//
//            //dd('is null');
//
//            $fuzzy_date = new FuzzyDate();
//
//            $byte_date = $fuzzy_date->makeByteDate(
//                $request->year,
//                $request->month,
//                $request->day,
//                $request->hour,
//                $request->minute,
//                $request->seconds
//            );
//
//            //dd("Input: " . $byte_date['datetime']);
//
//        } else {
//
//            //dd('not null');
//
//            $byte_date = array("datetime" => $image_date['datetime'],
//                "accuracy" => $image_date['accuracy']);
//
//            //dd("Image: " . $byte_date['datetime']);
//
//        }
//
//        $timeZone = \App\Zone::where('id', '=', $request->zone_id)->first();
//
//        $byte_date["datetime"] = $timestamp = Carbon::createFromFormat('Y:m:d H:i:s',
//            $byte_date["datetime"], $timeZone->zone_name);
//
//        //dd($byte_date);
//
//        return $byte_date;
//
//    }

    private function urlExists($url)
    {
        if (@file_get_contents($url, 0, NULL, 0, 1)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $exifCoord
     * @param $hemi
     * @return int
     */
    private function getGps($exifCoord, $hemi)
    {

        $degrees = count($exifCoord) > 0 ? $this->gps2Num($exifCoord[0]) : 0;
        $minutes = count($exifCoord) > 1 ? $this->gps2Num($exifCoord[1]) : 0;
        $seconds = count($exifCoord) > 2 ? $this->gps2Num($exifCoord[2]) : 0;

        $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

        return $flip * ($degrees + $minutes / 60 + $seconds / 3600);

    }

    /**
     * @param $coordPart
     * @return float|int
     */
    private function gps2Num($coordPart)
    {

        $parts = explode('/', $coordPart);

        if (count($parts) <= 0) {
            return 0;
        }

        if (count($parts) == 1) {
            return $parts[0];
        }

        return floatval($parts[0]) / floatval($parts[1]);
    }

}