<?php

namespace App\Controller;

use App\Entity\Director;
use App\Form\DirectorType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DirectorController extends AbstractController
{
    /**
     * @Route("/director", name="app_director")
     */
    public function index(ManagerRegistry $doctrine): Response
    {

        $directors = $doctrine->getRepository(Director::class)->findBy([],["surname_director" =>"ASC"]);

        return $this->render('director/index.html.twig', [
            'directors' => $directors,
        ]);
    }

     /**
     * @Route("/director/add", name="add_director")
     * @Route("director/update/{id}", name = "update_director")
     */
    public function add(ManagerRegistry $doctrine, Director $director = null, Request $request): Response
    {
        if(!$director){
            $director = new Director();
        }


        $entityManager = $doctrine->getManager();    
        $form = $this->createForm(DirectorType::class, $director);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // "hydration"
            $director = $form->getData();
            // creates object $director
            $entityManager->persist($director);
            // inserts data in database
            $entityManager->flush();

            return $this->redirectToRoute('app_director');
        }

        return $this->render ('director/add.html.twig', [
            'formDirector' => $form->createView()
        ]);
    }


     /**
     * @Route("director/delete/{id}", name = "delete_director")
     * 
     */
    public function delete(ManagerRegistry $doctrine, Director $director){
        $entityManager = $doctrine->getManager();
        $entityManager->remove($director);
        $entityManager->flush();
        return $this->redirectToRoute('app_director');
    }

    /**
     * @Route("/director/{id}", name="show_director")
     */
    public function show(Director $director):Response
    {
        return $this->render ('director/show.html.twig', [
            'director' => $director,
        ]);
    }


}
