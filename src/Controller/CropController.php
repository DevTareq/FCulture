<?php

namespace App\Controller;

use App\Entity\Crop;
use App\Form\CropType;
use App\Repository\CropRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crop")
 */
class CropController extends AbstractController
{
    /**
     * @Route("/", name="crop_index", methods={"GET"})
     */
    public function index(CropRepository $cropRepository): Response
    {
        return $this->render('crop/index.html.twig', [
            'crops' => $cropRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="crop_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $crop = new Crop();
        $form = $this->createForm(CropType::class, $crop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($crop);
            $entityManager->flush();

            return $this->redirectToRoute('crop_index');
        }

        return $this->render('crop/new.html.twig', [
            'crop' => $crop,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="crop_show", methods={"GET"})
     */
    public function show(Crop $crop): Response
    {
        return $this->render('crop/show.html.twig', [
            'crop' => $crop,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="crop_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Crop $crop): Response
    {
        $form = $this->createForm(CropType::class, $crop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('crop_index', [
                'id' => $crop->getId(),
            ]);
        }

        return $this->render('crop/edit.html.twig', [
            'crop' => $crop,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="crop_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Crop $crop): Response
    {
        if ($this->isCsrfTokenValid('delete' . $crop->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($crop);
            $entityManager->flush();
        }

        return $this->redirectToRoute('crop_index');
    }
}
