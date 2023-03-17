<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BiographieController extends AbstractController
{
    /* Exemple : www.site.fr/biographie */
    #[Route('/biographie', name: 'app_biographie')]
    public function index(): Response
    {
        /* Afficher la page biographie.html.twig */
        return $this->render('biographie/index.html.twig', [
            'controller_name' => 'BiographieController',
        ]);
    }
}
