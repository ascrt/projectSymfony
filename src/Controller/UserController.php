<?php

namespace App\Controller;

use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/inscription', name: 'app_user_registration')]
    public function registration(Request $request, UserRepository $repository, UserPasswordHasherInterface $hasher) : Response
    {
        //Creation du formulaire
        $form = $this->createForm(RegistrationType::class);

        //Remplissage du formulaire
        $form->handleRequest($request);
        
        //Test de Validation
        if($form->isSubmitted() && $form->isValid()) {

            //Recuperation des donnees
            $user = $form->getData();

            //crypter le mot de passe
            $cryptedPass= $hasher->hashPassword($user , $user->getPassword()); // c'est ici que le mdp ecrit en clair se transforme en hash
            $user->setPassword($cryptedPass);

            //Enregistrement dans la BDD
            $repository->save($user, true);


            //Redirection
            return $this->redirectToRoute('app_pizza_home');
        }

        //Rendu
        return $this->render('user/registration.html.twig', [
            'form' => $form->createView(),
        ]); 
    }
}
