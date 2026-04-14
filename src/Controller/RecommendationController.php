<?php

namespace App\Controller;

use App\Entity\Recommendation;
use App\Form\RecommendationType;
use App\Repository\RecommendationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recommendation')]
final class RecommendationController extends AbstractController
{
    #[Route(name: 'app_recommendation_index', methods: ['GET'])]
    public function index(RecommendationRepository $recommendationRepository): Response
    {
        return $this->render('recommendation/index.html.twig', [
            'recommendations' => $recommendationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_recommendation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recommendation = new Recommendation();
        $form = $this->createForm(RecommendationType::class, $recommendation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recommendation);
            $entityManager->flush();

            return $this->redirectToRoute('app_recommendation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recommendation/new.html.twig', [
            'recommendation' => $recommendation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recommendation_show', methods: ['GET'])]
    public function show(Recommendation $recommendation): Response
    {
        return $this->render('recommendation/show.html.twig', [
            'recommendation' => $recommendation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recommendation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recommendation $recommendation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecommendationType::class, $recommendation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_recommendation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recommendation/edit.html.twig', [
            'recommendation' => $recommendation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recommendation_delete', methods: ['POST'])]
    public function delete(Request $request, Recommendation $recommendation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recommendation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($recommendation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_recommendation_index', [], Response::HTTP_SEE_OTHER);
    }
}
