<?php namespace App;

use OutOfBoundsException;

/**
 * Class Config
 *
 * @package App
 */
class Config {

    protected $configFile = "config.ini";
    protected $configArray;
    const PATH_TO_SQLITE_FILE = 'db/phpsqlite.db';

    public function __construct()
    {
        $this->configArray = $this->parseConfig($this->configFile);
    }

    /**
     * Return config value from .ini file
     *
     * @param $configParam
     * @param null $key
     * @return mixed
     */
    public function getConfig($configParam, $key = NULL)
    {
        $logParam = ($key) ? $configParam.'['.$key.']' : $configParam;
        $errorTxt = sprintf("Given config parameter: '%s' did not found in configuration file!", $logParam);
        $config = ($key) ? $this->getConfig($configParam) : $this->configArray;
        $configParam = ($key) ? $key : $configParam;

        if ( ! isset($config[$configParam])) {
            throw new OutOfBoundsException($errorTxt);
        }

        return $config[$configParam];
    }

    /**
     * Parse config file and return data
     *
     * @param $configFile
     * @return array
     */
    private function parseConfig($configFile)
    {
        return parse_ini_file($configFile);
    }

}