<?php

namespace App\Controller;

use App\Entity\Casting;
use App\Form\CastingType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CastingController extends AbstractController
{
    /**
     * @Route("/casting", name="app_casting")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $castings = $doctrine->getRepository(Casting::class)->findAll();

        return $this->render('casting/index.html.twig', [
            'castings' => $castings,
        ]);
    }


    /**
     * @Route("/casting/add", name="add_casting")
     * @Route("casting/update/{id}", name = "update_casting")
     */
    public function add(ManagerRegistry $doctrine, Casting $casting = null, Request $request): Response
    {
        if(!$casting){
            $casting = new Casting();
        }


        $entityManager = $doctrine->getManager();    
        $form = $this->createForm(CastingType::class, $casting);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // "hydration"
            $casting = $form->getData();
            // creates object $director
            $entityManager->persist($casting);
            // inserts data in database
            $entityManager->flush();

            return $this->redirectToRoute('app_casting');
        }

        return $this->render ('casting/add.html.twig', [
            'formCasting' => $form->createView()
        ]);

    }
}
