<?php

require 'vendor/autoload.php';

use Classes\Transport;
use Classes\Car;
use Classes\Bicycle;
use Classes\Boat;

$transport = new Transport();
$car = new Car('Mazda CX-5', 'Автомобіль', 240, 5, 2.5, 230);
$bicycle = new Bicycle('Hammer', 'Велосипед', 60, 10, 7);
$boat = new Boat('Titanic', 'Лайнер', 30, 2500, 1345, 'Двигун');

$data = [$car, $bicycle, $boat];

echo $car->getInfo().PHP_EOL;
echo $bicycle->getInfo().PHP_EOL;
echo $boat->getInfo().PHP_EOL.PHP_EOL;

echo $car->startEngine().PHP_EOL;
echo $bicycle->ringBell().PHP_EOL;
echo $boat->travel().PHP_EOL.PHP_EOL;

print_r($transport->getAllObjects($data));