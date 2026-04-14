<?php

namespace App\Controller;

use App\Entity\ItemCatalog;
use App\Form\ItemCatalogType;
use App\Repository\ItemCatalogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/item/catalog')]
final class ItemCatalogController extends AbstractController
{
    #[Route(name: 'app_item_catalog_index', methods: ['GET'])]
    public function index(ItemCatalogRepository $itemCatalogRepository): Response
    {
        return $this->render('item_catalog/index.html.twig', [
            'item_catalogs' => $itemCatalogRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_item_catalog_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $itemCatalog = new ItemCatalog();
        $form = $this->createForm(ItemCatalogType::class, $itemCatalog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($itemCatalog);
            $entityManager->flush();

            return $this->redirectToRoute('app_item_catalog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('item_catalog/new.html.twig', [
            'item_catalog' => $itemCatalog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_item_catalog_show', methods: ['GET'])]
    public function show(ItemCatalog $itemCatalog): Response
    {
        return $this->render('item_catalog/show.html.twig', [
            'item_catalog' => $itemCatalog,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_item_catalog_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ItemCatalog $itemCatalog, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItemCatalogType::class, $itemCatalog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_item_catalog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('item_catalog/edit.html.twig', [
            'item_catalog' => $itemCatalog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_item_catalog_delete', methods: ['POST'])]
    public function delete(Request $request, ItemCatalog $itemCatalog, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemCatalog->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($itemCatalog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_item_catalog_index', [], Response::HTTP_SEE_OTHER);
    }
}
