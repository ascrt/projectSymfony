<?php

namespace App\Controller;

use App\Repository\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PizzaController extends AbstractController
{
    #[Route('/pizza', name: 'app_pizza')]
    public function index(): Response
    {
        return $this->render('pizza/index.html.twig', [
            'controller_name' => 'PizzaController',
        ]);
    }

    #[Route('/home', name: 'app_pizza_home')]
    public function list(PizzaRepository $repository) : Response
    {
        // READ

        /*** Liste des pizzas dans la BDD ***/
        $pizzas = $repository->findAll();

        //Rendu
        return $this->render('pizza/home.html.twig', [
            'pizzas' => $pizzas
        ]);
    }
}
