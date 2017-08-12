<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2017-07-20
 * Time: 9:12 PM
 */

namespace App\Lifecanvas\Utilities;

// TODO-KGW This script was taken from the 5.1 version. I couldn't get it to work when ported.

class FileManagement
{
    /**
     * Create  Directory Tree if Not Exists
     * If you are passing a path with a filename on the end, pass true as the second parameter to snip it off
     *
     * @param $pathname
     * @param bool|false $is_filename
     * @return bool
     */
    public function makePath($pathname, $is_filename = false, $mode = 0777)
    {
        if ($is_filename) {
            $pathname = substr($pathname, 0, strrpos($pathname, '/'));
        }

        // Check if directory already exists
        if (is_dir($pathname) || empty($pathname)) {
            return true;
        }

        // Ensure a file does not already exist with the same name
        $pathname = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $pathname);

        if (is_file($pathname)) {
            trigger_error('mkdirr() File exists', E_USER_WARNING);
            return false;
        }

        // Crawl up the directory tree
        $next_pathname = substr($pathname, 0, strrpos($pathname, DIRECTORY_SEPARATOR));

        if ($this->makePath($next_pathname, $mode)) {
            if (!file_exists($pathname)) {
                return mkdir($pathname, $mode);
            }
        }
        return false;
    }
}