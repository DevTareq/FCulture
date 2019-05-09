<?php

namespace App\Controller;

use App\Entity\Tractor;
use App\Form\TractorType;
use App\Repository\TractorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tractor")
 */
class TractorController extends AbstractController
{
    /**
     * @Route("/", name="tractor_index", methods={"GET"})
     */
    public function index(TractorRepository $tractorRepository): Response
    {
        return $this->render('tractor/index.html.twig', [
            'tractors' => $tractorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tractor_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tractor = new Tractor();
        $form = $this->createForm(TractorType::class, $tractor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tractor);
            $entityManager->flush();

            return $this->redirectToRoute('tractor_index');
        }

        return $this->render('tractor/new.html.twig', [
            'tractor' => $tractor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tractor_show", methods={"GET"})
     */
    public function show(Tractor $tractor): Response
    {
        return $this->render('tractor/show.html.twig', [
            'tractor' => $tractor,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tractor_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tractor $tractor): Response
    {
        $form = $this->createForm(TractorType::class, $tractor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tractor_index', [
                'id' => $tractor->getId(),
            ]);
        }

        return $this->render('tractor/edit.html.twig', [
            'tractor' => $tractor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tractor_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tractor $tractor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tractor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tractor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tractor_index');
    }
}
