<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    #[Route('/home', name: 'app_home')]
    public function index(CallApiService $callApiService): Response
    {
        $image_url = 'https://image.tmdb.org/t/p/w500';
        // dd($callApiService->getPopularMovies());
        return $this->render('home/index.html.twig', [
            'popularMovies' => $callApiService->getPopularMovies(),
            'image_url' => $image_url,
        ]);
    }
}
