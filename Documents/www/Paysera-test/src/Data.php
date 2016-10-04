<?php namespace App;

use Exception;
use InvalidArgumentException;

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
        $result = array();
        foreach (explode("\n", $this->getInput()) as $row) {

            $dataRow = array_combine(array_keys(config('data_matrix')), explode(config('data_separator'), $row));
            try {
                $dataRow = $this->checkDataType($dataRow, config('data_matrix'));
                $result[] = $dataRow;
//                echo implode(config('data_separator'), $dataRow) . "\n";
            } catch (InvalidArgumentException $e) {
//                echo $e->getMessage() . "\n";
            }
        }

        return $result;
    }

    /**
     * Check data values types
     *
     * @param $dataRow
     * @param $dataTypes
     * @return array|boolean
     */
    private function checkDataType($dataRow, $dataTypes)
    {
        foreach ($dataRow as $key => $value) {
            $type = $dataTypes[$key];
            $newValue = $value;
            settype($newValue, $type);
            if ((string) $value != (string) $newValue) {
                throw new InvalidArgumentException(sprintf('Given value: %s is not of type \'%s\'.', $value, $type));
                //return FALSE;
            }
            $dataRow[$key] = $newValue;
        }

        return $dataRow;
    }

}