<?php

use Dixons\Http\Kernel;

require __DIR__.'/../vendor/autoload.php';

$d = \Dixons\Implementation\Time\Duration::inSeconds(86400);

$kernel = new Kernel();

$kernel->run();