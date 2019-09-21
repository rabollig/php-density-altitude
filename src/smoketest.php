<?php

require "DensityAltitude.php";

$calculator = new rabollig\DensityAltitude();
$calculator->altitudeInFeet(702.1);
$calculator->temperatureInF(84.57);
$calculator->dewpointInF(59);
$calculator->altimeterPressureInInchesHg(30.29);
$calculator->DANGERthisClassNotIntendedForSafetyCriticalUses('understood');
echo $calculator->calculateDensityAltitude();

echo PHP_EOL;
echo PHP_EOL;



$calculator = new rabollig\DensityAltitude();
$calculator->altitudeInFeet(998.4);
$calculator->temperatureInC(27);
$calculator->dewpointInC(14);
$calculator->altimeterPressureInInchesHg(30.28);
$calculator->DANGERthisClassNotIntendedForSafetyCriticalUses('understood');
echo $calculator->calculateDensityAltitude();
//2200
echo PHP_EOL;
echo PHP_EOL;
