<?php
namespace rabollig;

class DensityAltitude
{

    private $agreedDisclaimer = false;
    private $altitudeInMeters = null;
    private $altitudeInFeet = null;
    private $temperatureInKelvin = null;
    private $altimeterPressureInMetric = null;
    private $dewpointInC = null;
    private $stationPressureInInchesHg = null;
    private $stationPressureInMillibars = null;
    private $virtualTemperatureInRankine = null;
    private $vaporPressure = null;
    private $outputUnits = null;

    public function __construct()
    {
    }

    public function altitudeInMeters($meters)
    {
        $this->altitudeInMeters = $meters;
        $this->altitudeInFeet   = $meters * .3048;
        $this->outputUnits = 'meters';
    }

    public function altitudeInFeet($feet)
    {
        $this->altitudeInFeet   = $feet;
        $this->altitudeInMeters = $feet * .3048;
        $this->outputUnits = 'feet';
    }

    public function altimeterPressureInInchesHg($reading)
    {
        $this->altimeterPressureInMetric = $reading;
    }

    public function altimeterPressureInMillimetersHg($reading)
    {
        $this->altimeterPressureInMetric = $reading * 25.4;
    }

    public function temperatureInC($reading)
    {
        $this->temperatureInKelvin = $reading + 273.16;
    }

    public function temperatureInF($reading)
    {
        // Convert to celsius
        $celsius = 5/9 * ($reading - 32);
        $this->temperatureInC($celsius);
    }

    public function dewpointInC($reading)
    {
        $this->dewpointInC = $reading;
    }

    public function dewpointInF($reading)
    {
        // Convert to Celsius
        $celsius = 5/9 * ($reading - 32);
        $this->dewpointInC = $celsius;
    }

    public function DANGERthisClassNotIntendedForSafetyCriticalUses($response)
    {
        $this->agreedDisclaimer = true;
    }

    public function calculateDensityAltitude()
    {
        // Verify disclaimer agreed
        if (!$this->agreedDisclaimer) {
            throw new Exception('You must acknowledge the disclaimer. Please read the documentation.');
        }

        // Calculate the components
        $this->calculateStationPressure();
        $this->calculateVirtualTemperature();
        $this->calculateVaporPressure();

        // Calculate the density altitude
        $hDensity = 145366 *
            (1 - (pow((17.326 * $this->stationPressureInInchesHg / $this->virtualTemperatureInRankine), 0.235)));

        // Output in the preferred units
        if ($this->outputUnits == 'feet') {
            return $hDensity;
        }
        if ($this->outputUnits == 'meters') {
            return $hDensity * 12 * 2.54 / 100;
        }
    }

    private function calculateStationPressure()
    {
        // Blow error if missing inputs
        if (is_null($this->altitudeInFeet) && is_null($this->altitudeInMeters)) {
            throw new Exception("Station Altitude not set. Use setAltitudeMeters() or setAltitudeFeet()");
        }

        if (is_null($this->altimeterPressureInMetric)) {
            throw new Exception(
                "Altimeter reading not set. Use altimeterPressureInMillimetersHg() or altimeterPressureInInchesHg()"
            );
        }

        $stationPressure = $this->altimeterPressureInMetric
            * pow(((288 - 0.0065 * $this->altitudeInMeters) / 288), 5.2561);
        $this->stationPressureInInchesHg = $stationPressure;
        $this->stationPressureInMillibars = $this->convertInchesHgToMillibars($stationPressure);

        return $stationPressure;
    }


    private function calculateVaporPressure()
    {
        $Td = $this->dewpointInC;
        $this->vaporPressure = 6.11 * pow(10, ((7.5 * $Td)/(237.7 + $Td)));
    }

    private function calculateVirtualTemperature()
    {
        $this->stationPressureInMillibars = $this->convertInchesHgToMillibars($this->stationPressureInInchesHg);

        $TvK = $this->temperatureInKelvin
            / (1 - ($this->virtualTemperature/$this->stationPressureInMillibars) * (1-0.622));
        $this->virtualTemperatureInRankine = $this->convertKelvinToRankine($TvK);
    }

    private function convertInchesHgToMillibars($input)
    {
        return 33.8639 * $input;
    }

    private function convertKelvinToRankine($input)
    {
        return ((9/5) * ($input - 273.16) +32 ) + 459.69;
    }
}
