<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Entity\Basket;
use App\Entity\Article;
use App\Repository\BasketRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[IsGranted("ROLE_USER")]
class BasketController extends AbstractController
{
    #[Route('/basket', name: 'app_basket')]
    public function index(): Response
    {
        return $this->render('basket/index.html.twig', [
            'controller_name' => 'BasketController',
        ]);
    }

    
    #[Route('/mon-panier', name: 'app_panier')]
    public function display() : Response
    {
        return $this->render('basket/panier.html.twig');   
    }

    #[Route('/mon-panier/{id}/ajouter', name: 'app_panier_ajouter')]
    public function addArticle(Pizza $pizza, BasketRepository $repository) : Response 
    {
        //Recuperation du panier de l'utilisateur

        /** Récuperation de l'utilisateur **/
        $user = $this->getUser();

        /** Receperation de cet utilisateur **/
        $basket = $user->getBasket();

        //créer un nouvel article
        $article = new Article();

        /***Inserer une quantité dans cet article ***/
        $article->setQuantity(1);
        /*** Inserer le panier dans cet article */
        $article->setBasket($basket);
        /*** Inserer la pizza dans cet article ***/
        $article->setPizza($pizza);

        //Ajout de l'article correspondant à l'id dans le panier 

        $basket->addArticle($article);

        //Enrgisterment dans la BDD
        $repository->save($basket, true);

        //Redirection 
        return $this->redirectToRoute('app_panier');
    } 

}
