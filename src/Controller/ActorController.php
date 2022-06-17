<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Form\ActorType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActorController extends AbstractController
{
    /**
     * @Route("/actor", name="app_actor")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $actors = $doctrine->getRepository(Actor::class)->findBy([],["surname_actor" =>"ASC"]);

        return $this->render('actor/index.html.twig', [
            'actors' => $actors,
        ]);
    }


    /**
     * @Route("/actor/add", name="add_actor")
     * @Route("actor/update/{id}", name = "update_actor")
     */
    public function add(ManagerRegistry $doctrine, Actor $actor = null, Request $request): Response
    {
        if(!$actor){
            $actor = new Actor();
        }


        $entityManager = $doctrine->getManager();    
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // "hydration"
            $actor = $form->getData();
            // creates object $director
            $entityManager->persist($actor);
            // inserts data in database
            $entityManager->flush();

            return $this->redirectToRoute('app_actor');
        }

        return $this->render ('actor/add.html.twig', [
            'formActor' => $form->createView()
        ]);
    }


    /**
     * @Route("actor/delete/{id}", name = "delete_actor")
     * 
     */
    public function delete(ManagerRegistry $doctrine, Actor $actor){
        $entityManager = $doctrine->getManager();
        $entityManager->remove($actor);
        $entityManager->flush();
        return $this->redirectToRoute('app_actor');
    }

     /**
     * @Route("/actor/{id}", name="show_actor")
     */
    public function show(Actor $actor):Response
    {
        return $this->render ('actor/show.html.twig', [
            'actor' => $actor,
        ]);
    }
}
