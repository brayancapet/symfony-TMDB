<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Search;
use App\Form\FilmType;
use App\Form\SearchFormType;
use App\Service\CallApiService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{


    #[Route('/search', name: 'app_search')]
    public function index(Request $request, CallApiService $callApiService): Response
    {

        // Nouvelle recherche
        $search = new Search();
        $film = new Film();

        // Création Search form
        $form = $this->createForm(SearchFormType::class, $search);
        $film_form = $this->createForm(FilmType::class, $film);

        // Récupération du $_GET ou $_POST
        // $form->handleRequest($request);
        $film_form->handleRequest($request);
        

        if ($film_form->isSubmitted() && $film_form->isValid()){
            $data = $film_form->getData();
            $film->setTitre($data->getTitre());
            $user = $this->getUser();
            $film->setImage($data->getImage());
            $film->setSynopsis($data->getSynopsis());
            $film->setUser($user);
        }
        

        $image_url = 'https://image.tmdb.org/t/p/w500';
        return $this->render('search/index.html.twig', [
            'form'=> $form->createView(),
            'image_url' => $image_url,
            'film_form' => $film_form->createView(),
        ]);


    }

    
    
}
