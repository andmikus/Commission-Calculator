<?php namespace App;

use Exception;

/**
 * Class Data
 * Convert data from input source to array
 *
 * @package App
 */
class Data {


    private $input;
    public $dataSource;

    public function __construct(Input $input, $dataSource)
    {
        $this->input = $input;
        $this->dataSource = $dataSource;
    }

    /**
     * Read data from given input source
     *
     * @return string
     * @throws Exception
     */
    public function getInput()
    {
        if ( ! isset($this->dataSource)) {
            throw new Exception('No input has been set!');
        }

        return $this->input->getData($this->dataSource);
    }

    /**
     * Combine input string data to associative array
     *
     * @return array
     */
    public function dataMatrix()
    {
        echo $this->getInput();
        $result = array();
        foreach (explode("\n", $this->getInput()) as $row) {

            $dataRow = array_combine(array_keys(config('data_matrix')), explode(config('data_separator'), $row));
            $result[] = $dataRow;
        }

        return $result;
    }

}