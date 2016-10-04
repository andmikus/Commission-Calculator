#! /usr/bin/env php

<?php

use App\Controller;

require 'vendor/autoload.php';

/**
 * Commission calculator program.
 * Calculate commission fees for given cash in/out transactions
 *
 * @package App
 * @author Andrius Mickus <andriusm@lotelita.lt>
 */

//Get parameter
$input = $argv[1];

$data = new Controller();
$data->execute($input);
