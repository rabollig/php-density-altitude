<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class DensityAltitudeTest extends TestCase
{

    public function setUp() :void
    {
        require_once __DIR__ . "/../src/DensityAltitude.php";
    }

    public function testFromAWOS()
    {
        $calculator = new rabollig\DensityAltitude();
        $calculator->altitudeInFeet(998.4);
        $calculator->temperatureInC(27);
        $calculator->dewpointInC(14);
        $calculator->altimeterPressureInInchesHg(30.28);
        $calculator->DANGERthisClassNotIntendedForSafetyCriticalUses('understood');
        $this->assertEquals(
            2200, 
            round($calculator->calculateDensityAltitude()/100) * 100
        );
    }

    public function testTemperatureGoesUpDensityAltitudeGoesUp()
    {
        $calculator = new rabollig\DensityAltitude();
        $calculator->altitudeInFeet(998.4);
        $calculator->temperatureInC(27);
        $calculator->dewpointInC(14);
        $calculator->altimeterPressureInInchesHg(30.28);
        $calculator->DANGERthisClassNotIntendedForSafetyCriticalUses('understood');

        $low = $calculator->calculateDensityAltitude();

        $calculator->temperatureInC(30);

        $high = $calculator->calculateDensityAltitude();

        $this->assertGreaterThan($low, $high);

    }

    public function testTextbookExample() // From Jeppeson Private Pilot Manual
    {
        $calculator = new rabollig\DensityAltitude();
        $calculator->altitudeInFeet(8000);
        $calculator->temperatureInF(68);
        $calculator->dewpointInF(68);
        $calculator->altimeterPressureInInchesHg(29.92);
        $calculator->DANGERthisClassNotIntendedForSafetyCriticalUses('understood');

        $da = round($calculator->calculateDensityAltitude()/100) * 100;
	$this->assertEquals(10400, $da);
    }





}



