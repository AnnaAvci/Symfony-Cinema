<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Role;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoleController extends AbstractController
{
    /**
     * @Route("/role", name="app_role")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $roles = $doctrine->getRepository(Role::class)->findBy([],['name_role'=>"ASC"]);

        return $this->render('role/index.html.twig', [
            'roles' => $roles,
        ]);
    }


    // Methods using id need to be at the end, to avoid confusion with /add being taken for an id etc
    /**
     * @Route("/role/{id}", name="show_role")
     */
    public function show(Role $role):Response
    {
        return $this->render ('role/show.html.twig', [
            'role' => $role,
        ]);
    }
}
