<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WeatherController extends AbstractController
{
    #[Route('/', name: 'app_weather')]
    public function index(): Response
    {
        $draw = random_int(1, 100);

        $weather = $draw <= 50 ? "Its sunny!" : "Its rainy!";

        return $this->render('weather/index.html.twig', [
            'controller_name' => 'WeatherController',
            'weather' => $weather,
        ]);
    }
}
