<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StaticController extends AbstractController
{
    #[Route('/', name: 'app_static_home')]
    public function index(): Response
    {
        $draw = random_int(1, 100);

        $weather = $draw <= 50 ? "Its sunny!" : "Its rainy!";

        return $this->render('static/index.html.twig', [
            'controller_name' => 'StaticController',
        ]);
    }
}
