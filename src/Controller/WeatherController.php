<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{country_code}/{city}', name: 'app_weather')]
    public function index(string $country_code, string $city): Response
    {
        $temprature = random_int(-20, 100);

        $weather = [
            'country_code' => $country_code,
            'city' => $city,
            'temperature' => $temprature,
        ];

        return $this->render('weather/index.html.twig', [
            'controller_name' => 'WeatherController',
            'weather' => $weather,
        ]);
    }
}
