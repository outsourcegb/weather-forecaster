<?php
// src/DataFixtures/LocationFixtures.php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LocationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $location = new Location();
            $location->setName($faker->city)
                ->setCountryCode($faker->countryCode)
                ->setLatitude($faker->latitude)
                ->setLongitude($faker->longitude);

            $manager->persist($location);

            // Store reference for use in other fixtures
            $this->addReference('location_' . $i, $location);
        }

        $manager->flush();
    }
}
