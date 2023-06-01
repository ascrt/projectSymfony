<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Entity\Basket;
use App\Entity\Article;
use App\Repository\BasketRepository;
use App\Repository\ArticleRepository;
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

    //Ajouter un aricle 
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
    
    
    #[Route('/mon-panier/{id}/plus', name: 'app_panier_plus')]
    public function plus (Article $article, ArticleRepository $repository) : Response 
    {
        //ajouter +1  la quantié 
        $quantite = $article->getQuantity();

        $article->setQuantity($quantite + 1);

        //Sauvegarde dans la BDD
        $repository->save($article, true);

        //redirection vers le panier
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/mon-panier/{id}/moins', name: 'app_panier_moins')]
    public function minus(Article $article, ArticleRepository $repository, BasketRepository $basketrepo) : Response
    {
        //mettre la qté à -1
        $quantite = $article->getQuantity();
        $article->setQuantity($quantite - 1);

        //test si la qté est à 0
        if($article->getQuantity() <= 0) {

            //supprmier l'article du panier
             /** Recuperer l'utilisateur **/
             $user = $this->getUser();

             /** Receperer son panier **/
             $basket = $user->getBasket();
            
            // Supprimer l'article
            $basket->removeArticle($article);

            //mise à jour du panier
            $basketrepo->save($basket, true);

            //Redirection
            return $this->redirectToRoute('app_panier');
        }

        //
        $repository->save($article,true);

        return $this->redirectToRoute('app_panier');

    }

    // Supprimer du panier
    #[Route('/mon-panier/{id}/delete', name: 'app_panier_supprimer')]
    public function delete(Article $article, BasketRepository $repository): Response
    {
         //supprmier l'article du panier
        /** Recuperer l'utilisateur **/
         $user = $this->getUser();

        /** Receperer son panier **/
        $basket = $user->getBasket();
            
        // Supprimer l'article
        $basket->removeArticle($article);

        //mise à jour du panier
        $repository->save($basket, true);

        //Redirection
        return $this->redirectToRoute('app_panier');
    }

}
