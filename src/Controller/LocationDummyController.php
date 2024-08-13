<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/location-dummy', name: 'app_location_dummy')]
class LocationDummyController extends AbstractController
{
    #[Route('/', name: 'app_location_dummy_index')]
    public function index(LocationRepository $locationRepository): JsonResponse
    {
        // get all locations
        $locations = $locationRepository->findAll();

        $json = [];

        foreach ($locations as $location) {
            $locationJson = [
                'id' => $location->getId(),
                'name' => $location->getName(),
                'country_code' => $location->getCountryCode(),
                'latitude' => $location->getLatitude(),
                'longitude' => $location->getLongitude(),
            ];

            foreach ($location->getForecasts() as $forecast) {
                $locationJson['forecasts'][$forecast->getDate()->format('Y-m-d')] = [
                    'celcius' => $forecast->getCelsius(),
                ];
            }

            $json[] = $locationJson;
        }

        return $this->json([
            'message' => 'Show all locations!',
            'locations' => $json,
        ]);
    }

    #[Route('/create', name: 'app_location_dummy_create')]
    public function create(LocationRepository $locationRepository): JsonResponse
    {
        // $location = new Location();
        // $location->setName('Nantes')
        //     ->setCountryCode('FR')
        //     ->setLatitude('47.2240')
        //     ->setLongitude('1.5408');
        // $em->persist($location);
        // $em->flush();

        // Get last location using the repository

        $location = new Location();
        $location
            ->setName('Nantes ' . rand(1, 100))
            ->setCountryCode('FR')
            ->setLatitude('47.2240')
            ->setLongitude('1.5408');
        $locationRepository->save($location, true);

        return $this->json([
            'message' => 'Createed a new location!',
            'location' => $location,
        ]);
    }

    #[Route('/{id}', name: 'app_location_dummy_show')]
    public function show(Location $location): JsonResponse
    {
        $json = [
            'id' => $location->getId(),
            'name' => $location->getName(),
            'country_code' => $location->getCountryCode(),
            'latitude' => $location->getLatitude(),
            'longitude' => $location->getLongitude(),
        ];

        foreach ($location->getForecasts() as $forecast) {
            $json['forecasts'][$forecast->getDate()->format('Y-m-d')] = [
                'celcius' => $forecast->getCelsius(),
            ];
        }

        return $this->json([
            'message' => 'Show a location!',
            'location' => $json,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_location_dummy_edit')]
    public function edit(Location $location, EntityManagerInterface $em): JsonResponse
    {
        $location->setName('Nantes 1')
            ->setCountryCode('FR')
            ->setLatitude('47.2240')
            ->setLongitude('1.5408');
        $em->persist($location);
        $em->flush();

        return $this->json([
            'message' => 'Updated a location!',
            'location' => $location,
        ]);
    }

    // #[Route('/{id}', name: 'app_location_dummy_delete', methods: ['DELETE'])]
    #[Route('/{id}/remove', name: 'app_location_dummy_delete')]
    public function delete(Location $location, EntityManagerInterface $em): JsonResponse
    {
        if (!$location) {
            $this->createNotFoundException('Location does not exist');
        }

        $em->remove($location);
        $em->flush();

        return $this->json([
            'message' => 'Deleted a location!',
            JsonResponse::HTTP_OK,
        ]);
    }
}
