<?php

namespace App\Http\Controllers;

use App\Lifecanvas\Vendor\SlimStatus;
use Illuminate\Http\Request;
use App\Lifecanvas\Vendor\Slim;
use Illuminate\Support\Facades\Auth;

class PhotoController extends Controller
{
    public function fetch ()
    {
        // Uncomment if you want to allow posts from other domains
        // header('Access-Control-Allow-Origin: *');
        //require_once('slim.php');


        // Get the requested remote url from the post
        $url = $_GET['url'];


        // Get the image data
        // Will stop fetching at the 10 megabyte mark
        $data = Slim::fetchURL($url, 10485760);


        // No support for "allow_url_open"
        if ($data === null) {
            Slim::outputJSON(array(
                'status' => SlimStatus::FAILURE,
                'message' => 'URL load failed, "allow_url_fopen" is not enabled. Add "allow_url_fopen = On" to your php.ini file.'
            ));
            return;
        }


        // Something else went wrong (for instance, remote server is down)
        if ($data === false) {
            Slim::outputJSON(array(
                'status' => SlimStatus::FAILURE,
                'message' => 'URL load failed for unknown reasons.'
            ));
            return;
        }


        // get the file name from the url
        $name = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);


        // If you want to store the file in another directory pass the directory name as the third parameter.
        // $file = Slim::saveFile($data, $name, 'my-directory/');
        $file = Slim::saveFile($data, $name);
        $filename = $file['path'];


        // Test if file is safe for use
        $type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filename);

        if (
            // is it not an image
        !(substr($type, 0, 6) === 'image/')
        ) {

            // remove file
            if (file_exists($filename)) {
                unlink($filename);
            }

            // echo error
            Slim::outputJSON(array(
                'status' => SlimStatus::FAILURE,
                'message' => 'URL load failed for unknown reasons.'
            ));

            return;
        }

        // return name of file on server
        Slim::outputJSON(array(
            'status' => SlimStatus::SUCCESS,
            'body' => $filename
        ));
    }

    public function async ()
    {
    // Uncomment if you want to allow posts from other domains
    // header('Access-Control-Allow-Origin: *');

        //require_once('slim.php');

        // Get posted data, if something is wrong, exit
        try {
            $images = Slim::getImages();
        }
        catch (Exception $e) {

            // Possible solutions
            // ----------
            // Make sure you're running PHP version 5.6 or higher

            Slim::outputJSON(array(
                'status' => SlimStatus::FAILURE,
                'message' => 'Unknown'
            ));

            return;
        }

        // No image found under the supplied input name
        if ($images === false) {

            // Possible solutions
            // ----------
            // Make sure the name of the file input is "slim[]" or you have passed your custom
            // name to the getImages method above like this -> Slim::getImages("myFieldName")

            Slim::outputJSON(array(
                'status' => SlimStatus::FAILURE,
                'message' => 'No data posted'
            ));

            return;
        }

        // Should always be one image (when posting async), so we'll use the first on in the array (if available)
        $image = array_shift($images);

        // Something was posted but no img were found
        if (!isset($image)) {

            // Possible solutions
            // ----------
            // Make sure you're running PHP version 5.6 or higher

            Slim::outputJSON(array(
                'status' => SlimStatus::FAILURE,
                'message' => 'No img found'
            ));

            return;
        }

        // If image found but no output or input data present
        if (!isset($image['output']['data']) && !isset($image['input']['data'])) {

            // Possible solutions
            // ----------
            // If you've set the data-post attribute make sure it contains the "output" value -> data-post="actions,output"
            // If you want to use the input data and have set the data-post attribute to include "input", replace the 'output' String above with 'input'

            Slim::outputJSON(array(
                'status' => SlimStatus::FAILURE,
                'message' => 'No image data'
            ));

            return;
        }

        // if we've received output data save as file
        if (isset($image['output']['data'])) {

            // get the name of the file
            $name = $image['output']['name'];

            // get the crop data for the output image
            $data = $image['output']['data'];

            // If you want to store the file in another directory pass the directory name as the third parameter.
            // $output = Slim::saveFile($data, $name, 'my-directory/');

            // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
            // $output = Slim::saveFile($data, $name, 'tmp/', false);

            // Default call for saving the output data
            $path = "usr/" . Auth::user()->id . "/avatar/";
            $output = Slim::saveFile($data, $name, $path);
        }

        // if we've received input data (do the same as above but for input data)
        if (isset($image['input']['data'])) {

            // get the name of the file
            $name = $image['input']['name'];

            // get the crop data for the output image
            $data = $image['input']['data'];

            // If you want to store the file in another directory pass the directory name as the third parameter.
            // $input = Slim::saveFile($data, $name, 'my-directory/');

            // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
            // $input = Slim::saveFile($data, $name, 'tmp/', false);

            // Default call for saving the input data
            $input = Slim::saveFile($data, $name);

        }



        //
        // Build response to client
        //
        $response = array(
            'status' => SlimStatus::SUCCESS
        );

        if (isset($output) && isset($input)) {

            $response['output'] = array(
                'file' => $output['name'],
                'path' => $output['path']
            );

            $response['input'] = array(
                'file' => $input['name'],
                'path' => $input['path']
            );

        }
        else {
            $response['file'] = isset($output) ? $output['name'] : $input['name'];
            $response['path'] = isset($output) ? $output['path'] : $input['path'];
        }

        // Return results as JSON String
        Slim::outputJSON($response);
    }
}
