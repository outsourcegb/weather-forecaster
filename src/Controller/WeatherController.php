<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\HighlanderApiDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/of_country/{country_code}/{city}', name: 'app_weather')]
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

    #[Route('/highlander-says/{threshold<\d+>}', priority: 1)]
    public function highlander(
        Request $request,
        RequestStack $requestStack,
        ?int $threshold = null,
        #[MapQueryParameter] ?string $_format = 'html'
    ): Response {
        $session = $requestStack->getSession();

        if ($threshold) {
            $session->set('threshold', $threshold);
        } else {
            $threshold = $session->get('threshold', 50);
        }

        $trials = $request->get('trials', 1);

        $forcast = [];

        for ($i = 0; $i < $trials; $i++) {
            $draw = random_int(0, 100);
            $forcast = $draw < $threshold ? 'It is going to rain' : 'It is going to be sunny';
            $forcasts[] = $forcast;
        }

        return $this->render("weather/highlander_says.{$_format}.twig", [
            'controller_name' => 'WeatherController',
            'threshold' => $threshold,
            'trials' => $trials,
            'forcasts' => $forcasts,
        ]);
    }

    #[Route('/weather/highlander_says/{guess}', name: 'app_highlander_threshold', methods: ['GET', 'POST'])]
    public function highlanderWithThreshold(string $guess): Response
    {
        $availableGuesses = ['snow', 'rain', 'hail', 'sunny', 'cloudy', 'windy'];

        if (!in_array($guess, $availableGuesses)) {
            // throw $this->createNotFoundException('This guess is not valid');
            // throw new NotFoundHttpException("This guess is not valid");
            throw new BadRequestException("This guess is not valid");
        }

        $weather = $guess;

        return $this->render('weather/highlander_says.html.twig', [
            'controller_name' => 'WeatherController',
            'weather' => $weather,
        ]);
    }
}
