<?php

namespace App\Controller;

use App\Entity\PlacedItem;
use App\Form\PlacedItemType;
use App\Repository\PlacedItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/placed/item')]
final class PlacedItemController extends AbstractController
{
    #[Route(name: 'app_placed_item_index', methods: ['GET'])]
    public function index(PlacedItemRepository $placedItemRepository): Response
    {
        return $this->render('placed_item/index.html.twig', [
            'placed_items' => $placedItemRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_placed_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $placedItem = new PlacedItem();
        $form = $this->createForm(PlacedItemType::class, $placedItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($placedItem);
            $entityManager->flush();

            return $this->redirectToRoute('app_placed_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('placed_item/new.html.twig', [
            'placed_item' => $placedItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_placed_item_show', methods: ['GET'])]
    public function show(PlacedItem $placedItem): Response
    {
        return $this->render('placed_item/show.html.twig', [
            'placed_item' => $placedItem,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_placed_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PlacedItem $placedItem, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlacedItemType::class, $placedItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_placed_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('placed_item/edit.html.twig', [
            'placed_item' => $placedItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_placed_item_delete', methods: ['POST'])]
    public function delete(Request $request, PlacedItem $placedItem, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$placedItem->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($placedItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_placed_item_index', [], Response::HTTP_SEE_OTHER);
    }
}
