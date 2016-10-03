<?php namespace App;

use Exception;

/**
 * Class File
 *
 * @package App
 */
class File implements Input{

    /**
     * Read data from input file
     *
     * @param $input_file
     * @return string
     * @throws Exception
     */
    public function getData($input_file)
    {
        if ( ! file_exists($input_file) or ! is_readable($input_file)) {
            throw new Exception('Can\'t open given input file!');
        }

        $fileHandle = fopen($input_file, "r");
        $data = fread($fileHandle, filesize($input_file));
        fclose($fileHandle);

        return $data;
    }
}