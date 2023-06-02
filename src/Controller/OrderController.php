<?php

namespace App\Controller;

use App\DTO\Payement;
use App\Entity\Order;
use App\Form\PayementType;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class OrderController extends AbstractController
{
    #[Route('/commander', name: 'app_commande')]
    public function display(Request $request, OrderRepository $repository): Response
    {
        //Création du payement
        $payement = new Payement();

        //Recuperer le panier de l'utilisateur connecté

        /*** Recupération de l'utilisateur ***/
        $user = $this->getUser();
        /*** Récupération du panier de l'utilisateur avec son adresse ***/
        $payement->address = $user->getAddress();
        
        //Formulaire de payement
        $form = $this->createForm(PayementType::class, $payement);

        /***Remplir le formulaire ***/
        $form->handleRequest($request);

        //Test du formulaire
        if($form->isSubmitted() && $form->isValid()) {
            
            //On crée une commande
            $order = new Order();

            //Inserer la commande a un utilisateur
            $order->setUser($user);

            //Pour chaque article du panier de l'utilisateur j'ajoute l'article puis je le supprime
            foreach($user->getBasket()->getArticles() as $article) {
                
                $order->addArticle($article);
                $order->removeArticle($article);
            }

            //Enregistrement dans la BDD
            $repository->save($order, true);

            //redirection
            return $this->redirectToRoute('app_order_validate', [
                "id" => $order->getId()
            ]);
        }


        return $this->render('order/commande.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    
    
    #[IsGranted('ROLE_USER')]
    #[Route('commande/{id}/validation', name: 'app_order_validate')]
    public function validate(Order $order): Response
    {
        
        //Rendu
        return $this->render('order/validation.html.twig', [
            'order' => $order,
            ]);
    }

    

    

}
