<?php

use XXX\Crawler;
use XXX\Parser\Billboard;
use XXX\Parser\Official;

date_default_timezone_set('Asia/Taipei');
require __DIR__ . '/../vendor/autoload.php';

$c = new Crawler();
$c->setDomain('http://www.billboard.com/charts/hot-100');
$c->setChartType('track');
$c->setParser(new Billboard());
$date = $c->getChartDate();
$list = $c->getChartList();
var_dump($date);
var_dump($list);

$c->setParser(new Official());
$c->setDomain('http://www.officialcharts.com/charts/singles-chart/');
$c->setChartType('track');
$date = $c->getChartDate();
$list = $c->getChartList();
var_dump($date);
var_dump($list);
