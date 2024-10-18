<?php

namespace App\Controller;

use App\Entity\Hostel;
use App\Form\HostelType;
use App\Repository\HostelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/hostel/crud')]
class HostelCrudController extends AbstractController
{
    #[Route('/', name: 'app_hostel_crud_index', methods: ['GET'])]
    public function index(HostelRepository $hostelRepository): Response
    {
        return $this->render('hostel_crud/index.html.twig', [
            'hostels' => $hostelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_hostel_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hostel = new Hostel();
        $form = $this->createForm(HostelType::class, $hostel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hostel);
            $entityManager->flush();

            return $this->redirectToRoute('app_hostel_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hostel_crud/new.html.twig', [
            'hostel' => $hostel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hostel_crud_show', methods: ['GET'])]
    public function show(Hostel $hostel): Response
    {
        return $this->render('hostel_crud/show.html.twig', [
            'hostel' => $hostel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hostel_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hostel $hostel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HostelType::class, $hostel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hostel_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hostel_crud/edit.html.twig', [
            'hostel' => $hostel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hostel_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Hostel $hostel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hostel->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($hostel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hostel_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
