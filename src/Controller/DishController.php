<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dish', name: 'dish.')]
class DishController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(DishRepository $ds): Response
    {
        $dishes = $ds->findAll();

        return $this->render('dish/index.html.twig', [
            'dishes' => $dishes
        ]);
    }
    #[Route('/add', name: 'add')]
    public function create(Request $request)
    {
        $dish = new Dish();
        $dish->setName('Pizza');

        //Entity Manager
        $em = $this->getDoctrine()->getManager();
        $em->persist($dish);
        $em->flush();

        return new Response("Dish created");
    }
}
