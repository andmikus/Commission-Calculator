#! /usr/bin/env php

<?php

use App\Controller;

require 'vendor/autoload.php';

$input = $argv[1];

$data = new Controller();
$data->execute($input);

echo "\n";
