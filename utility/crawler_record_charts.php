<?php

use XXX\Crawler\Billboard;
use XXX\Crawler\Official;

require __DIR__ . '/../vendor/autoload.php';

$o = new Official();
$o_list = $o->getChartList('track');

$b = new Billboard();
$b_list = $b->getChartList('track');
