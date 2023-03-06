<?php

namespace App\Controller;

use App\Repository\QuotationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(QuotationRepository $quotationRepository): Response
    {
        $aleatoire = rand(1,10);

        $citations = $quotationRepository
            ->find($aleatoire);

        return $this->render('frontend/base.html.twig', [
            'page' => 'Accueil',
            'controller_name' => 'MainController',
            'citations' => $citations
        ]);
    }
}
