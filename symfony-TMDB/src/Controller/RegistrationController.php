<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    private $passwordEncoder;
    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    #[Route('/registration', name: 'app_registration')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
       $user = new User(); // Création d'un utilisateur vide
       // Création d'un objet formulaire spécifique à un utilisateur 
       $form = $this->createForm(UserType::class, $user);
       // Récupération du $_GET ou du $_POST
       $form->handleRequest($request);

       // Si le formulaire est envoyé
       if ($form->isSubmitted() && $form->isValid()) {
           // Encodage du mdp utilisateur 
           $user->setPassword($this->passwordEncoder->hashPassword($user, $user->getPassword()));

           // Attribution d'un role
           $user->setRoles(['ROLE_USER']);

           // Sauvegarde dans la base de données
           $em = $doctrine->getManager();
           $em->persist($user);
           $em->flush();
           $this->addFlash('Success', 'Vous êtes enregistré');

           // Redirection vers la page login
           return $this->redirectToRoute('app_login');
       }

       return $this->render('registration/index.html.twig',[
           'form' => $form->createView(),
       ]);
    }
}
