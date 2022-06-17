<?php

namespace App\Controller;

use App\Entity\Genre;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenreController extends AbstractController
{
    /**
     * @Route("/genre", name="app_genre")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $genres = $doctrine->getRepository(Genre::class)->findBy([],['name_genre'=>"ASC"]);

        return $this->render('genre/index.html.twig', [
            'genres' => $genres,
        ]);
    }


    // Methods using id need to be at the end, to avoid confusion with /add being taken for an id etc
    /**
     * @Route("/genre/{id}", name="show_genre")
     */
    public function show(Genre $genre):Response
    {
        return $this->render ('genre/show.html.twig', [
            'genre' => $genre,
        ]);
    }
    
}
