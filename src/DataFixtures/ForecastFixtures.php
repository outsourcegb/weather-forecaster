<?php

namespace App\DataFixtures;

use App\Entity\Forecast;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ForecastFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Adjust the loop to match the number of locations created in LocationFixtures
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 10; $j++) {
                $forecast = new Forecast();
                $forecast->setCelsius($faker->randomFloat(2, -20, 40))
                    ->setDate($faker->dateTimeThisYear)
                    ->setCelsius($faker->randomFloat(2, -20, 40))
                    ->setFlTempratureCensius($faker->randomFloat(2, -20, 40))
                    ->setPressure($faker->numberBetween(900, 1100)) // Example range for pressure
                    ->setHumidity($faker->numberBetween(0, 100)) // Humidity percentage
                    ->setWindSpeed($faker->numberBetween(0, 150)) // Wind speed in km/h
                    ->setWindDeg($faker->numberBetween(0, 360)) // Wind direction in degrees
                    ->setCloudiness($faker->numberBetween(0, 100)) // Cloudiness percentage
                    ->setIcon($faker->imageUrl(250, 250, 'weather', true))
                    ->setLocation($this->getReference('location_' . $i));
                $manager->persist($forecast);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LocationFixtures::class,
        ];
    }
}
