<?php

use App\Config;

if ( ! function_exists('config')) {
    /**
     * Return parameter from config data
     *
     * @param $configParameter
     * @param null $key
     * @return mixed
     */
    function config($configParameter, $key = NULL) {
        $config = new Config();
        try {
            return $config->getConfig($configParameter, $key);
        } catch (OutOfBoundsException $e) {
            throw $e;
        }
    }
}

if ( ! function_exists('round_up')) {
    /**
     * Round float number up
     *
     * @param $value
     * @param int $places
     * @return string
     */
    function roundUp($value, $places = 0) {
        if ($places < 0) {
            $places = 0;
        }
        $multiplier = pow(10, $places);

        return number_format(ceil($value * $multiplier) / $multiplier, $places);
    }
}