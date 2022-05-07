<?php

namespace App\Controller;

use App\Entity\Search;
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

        // Création Search form
        $form = $this->createForm(SearchFormType::class, $search);

        // Récupération du $_GET ou $_POST
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $search->setTitre($data->getTitre());
        }
        

        $image_url = 'https://image.tmdb.org/t/p/w500';
        return $this->render('search/index.html.twig', [
            'form'=> $form->createView(),
            'image_url' => $image_url,
        ]);


    }

    
}
