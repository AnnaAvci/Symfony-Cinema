<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilmController extends AbstractController
{
    /**
     * @Route("/film", name="app_film")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $films = $doctrine->getRepository(Film::class)->findBy([],['date_film'=>"DESC"]);

        return $this->render('film/index.html.twig', [
            'films' => $films,
        ]);
    }


    /**
     * @Route("/film/add", name="add_film")
     * @Route("film/update/{id}", name ="update_film")
     */
    public function add(ManagerRegistry $doctrine, Film $film = null, Request $request): Response
    {
        if(!$film){
            $film = new Film();
        }


        $entityManager = $doctrine->getManager();    
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // "hydration"
            $film = $form->getData();
            // creates object $film
            $entityManager->persist($film);
            // inserts data in database
            $entityManager->flush();

            return $this->redirectToRoute('app_film');
        }

        return $this->render ('film/add.html.twig', [
            'formFilm' => $form->createView()
        ]);
    }


       /**
     * @Route("film/delete/{id}", name = "delete_film")
     */
    public function delete(ManagerRegistry $doctrine, Film $film){
        $entityManager = $doctrine->getManager();
        $entityManager->remove($film);
        $entityManager->flush();
        return $this->redirectToRoute('app_film');
    }

    // Methods using id need to be at the end, to avoid confusion with /add being taken for an id etc
      /**
     * @Route("/film/{id}", name="show_film")
     */
    public function show(Film $film):Response
    {
        return $this->render ('film/show.html.twig', [
            'film' => $film,
        ]);
    }
}
