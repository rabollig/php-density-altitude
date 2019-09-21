# php-density-altitude
Density Altitude calculator class for PHP based on formulas
published by the U.S. National Weather Service.

You know that warm air is less dense than colder air - this is
the principle that makes hot air balloons fly. Humidity, air
pressure and temperature can all change the air in a way that
makes altitude seem higher or lower than it actually is. When
the air is thinner because the temperature is warmer, we say
that the "density altitude" is higher. It is although you were
actually at a higher altitude on a standard day.

Density altitude can affect the oxygen intake to engines and
athletes, the performance of aircraft, and even beer brewing
and cake baking.

## DANGER!

### Do *not* use this class for safety-sensitive applications:
- Do not use for flight planning, operation or navigation
- Do not use for the diagnosis, prevention, or treatment of 
  any medical condition
- Do not use in nuclear facilities
- Do not use in any situation where failure or inaccurate information 
  could lead to injury, damage to property, loss of life,
  or catastrophe
  
**You must indicate your understanding of this disclaimer when calling the class**
  
  
### This class is not certified. This class has no engineering or scientific review.

This class was not developed by a physicist, meteorologist or 
engineer - nor has it been tested or reviewed by one.

### Notes on the formulas used
The developer is a private pilot, so has some clue about density
altitide. The formulas are based on 
https://www.weather.gov/epz/wxcalc_densityaltitude 
from the National Weather Service, apparently by Tim Brice
(tim.brice@noaa.gov) and Todd Hall (todd.hall@noaa.gov). The
formulas are referenced in PDF from 
https://www.weather.gov/media/epz/wxcalc/densityAltitude.pdf and
https://www.weather.gov/media/epz/wxcalc/pressureConversion.pdf
These formulas have a lot of steps, multiple mixed units, no
references or explanations. 

Wikipedia's article on density altitude,
https://en.wikipedia.org/wiki/Density_altitude , references 
three different formulas, none of which have citations. 

Wikipedia notes that the NWS standard should round to the nearest
100 feet. The documents from the NWS web site do not say this,
but also give no indication of significant figures.

When comparing the formula and class to FAA AWOS reports, the
100 foot rounding seems to give correct results.

Other formulas and calculators appear to give much different 
results. I don't have a clear enough understanding of 
density altitude to make judgements on why other reports and
calculators produce significantly different results.

https://airdensityonline.com/free-calcs/ is an example of 
another calculator that seems more knowledgable than me, but
gives pretty different answers. 

### Notes on testing

Even though I am a pilot, I will not rely on this class for 
navigation - I will instead rely on the Density Altitude charts,
official reports, or the E6B flight calculator. 

To test, I compared values computed to ASOS reports from airports
and the NWS JavaScript calculator referenced above.

I changed input values to make sure the calculated values
moved in the correct direction (nothing wired backwards).

I tested examples from flight training materials I own.


# Use

To calculate density altitude, we need to know the actual 
altitude, the temperature, the dewpoint, and the air pressure.

The class can accept inputs in several common units.

The class will output the density altitude in either feet
or meters depending on the units used to set the altitude
initially.

Inputs may be in any order.

```
$calculator = new DensityAltitude();
$calculator->altitudeInFeet(998.4);
$calculator->temperatureInC(27);
$calculator->dewpointInC(14);
$calculator->altimeterPressureInInchesHg(30.28);
$calculator->DANGERthisClassNotIntendedForSafetyCriticalUses('understood');
echo round($calculator->calculateDensityAltitude()); // 2225
```

You must include the method acknowledging the safety 
considerations of this class. This is required so that future
maintainers of your code are aware of the class's limitations
and do not blindly copy the code to more critical applications.

# Contributions

I welcome contributions - especially bug reports and criticism.

I would like for this class to someday be trustworthy enough
for actual flight operations, but I do not believe this is
something that one person can do on their own - it's too easy
to overlook mistakes.