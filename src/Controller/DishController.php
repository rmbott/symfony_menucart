<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Form\DishType;
use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use Symfony\Component\Form\Form as FormForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Entity\File;

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
        
        // Form
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);
        
        if($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dish);
            $em->flush();

            return $this->redirect($this->generateUrl('dish.add'));
        }

        return $this->render('dish/add.html.twig', [
            'addForm' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(int $id, DishRepository $dr)
    {
        $em = $this->getDoctrine()->getManager();
        $dish = $dr->find($id);
        $em->remove($dish);
        $em->flush();

        //message
        $this->addFlash('success', 'Dish has been deleted');
        
        return $this->redirect($this->generateUrl('dish.list'));
    }
}
