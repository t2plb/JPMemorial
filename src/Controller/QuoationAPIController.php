<?php

namespace App\Controller\Api;

use App\Entity\Quotation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/citations")
 */
class QuoationAPIController extends AbstractController
{
    /**
     * @Route("/", name="api_citation_list", methods={"GET"})
     */
    public function list(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Quotation::class);
        $citations = $repository->findAll();

        return $this->json($citations);
    }

    /**
     * @Route("/{id}", name="api_citation_get", methods={"GET"})
     */
    public function get(int|string $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Quotation::class);
        $citation = $repository->find($id);

        if (!$citation) {
            throw $this->createNotFoundException('Citation non trouvée.');
        }

        return $this->json($citation);
    }

    /**
     * @Route("/", name="api_citation_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $citation = new Quotation();
        $citation->setCitation($data['citation']);
        $citation->setAuteur($data['auteur']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($citation);
        $entityManager->flush();

        return $this->json($citation);
    }
}
