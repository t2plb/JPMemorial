<?php

namespace App\Controller;

use App\Repository\CredentialRepository;
use App\Repository\QuotationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainBackendController extends AbstractController
{
    #[Route('/backoffice', name: 'app_backoffice')]
    public function index(QuotationRepository $quotationRepository, CredentialRepository $credentialRepository): Response
    {
        $citations = $quotationRepository
            ->findAll();

        $credential = $credentialRepository
            ->findAll();
        return $this->render('backend/base.html.twig', [
            'page' => 'Back Office',
            'controller_name' => 'MainBackendController',
            'citations' => $citations,
            'users' => $credential
        ]);
    }

}
