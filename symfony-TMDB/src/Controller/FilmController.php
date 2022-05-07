<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\User;
use App\Form\FilmType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilmController extends AbstractController
{
    #[Route('/film', name: 'app_film')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $film = new Film(); // Création d'un film vide 
        // Création d'un objet formulaire spécifique à un film
        $form = $this->createForm(FilmType::class, $film);
        // Récupération du $_GET ou du $_POST
        $form->handleRequest($request);
        
        // Récupération de l'utilisateur connecté
        $user = $this->getUser();
        
        
        // Si le formulaire est envoyé 
        if ($form->isSubmitted() && $form->isValid()){
        //     // Ajout de l'id de l'utilisateur 
            $film->setUser($user);
            
        //     // Sauvegarde dans la bdd
            $em = $doctrine->getManager();
            $em->persist($film);
            $em->flush();
            $this->addFlash('success', 'Votre film est enregistré');
        //     // Redirection vers la page login
        //     return $this->redirectToRoute('show_film');
        }

        return $this->render('film/index.html.twig', [
            'form'=> $form->createView(),
        ]);

        
    }

    #[Route('/films', name: 'show_film')]

    public function show(): Response
    {
        // Récupération de l'utilisateur connecté
        $user = $this->getUser();

        // Récupération des films de l'utilisateur
        $films = $user->getFilms();

        return $this->render('film/show.html.twig', [
            'films'=> $films,
        ]);
    }
}
