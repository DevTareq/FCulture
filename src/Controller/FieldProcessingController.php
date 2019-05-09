<?php

namespace App\Controller;

use App\Entity\Crop;
use App\Entity\Field;
use App\Entity\FieldProcessing;
use App\Entity\Tractor;
use App\Form\FieldProcessingType;
use App\Repository\FieldProcessingRepository;
use App\Util\QueryParam\QueryParamFieldProcessing;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/processing")
 */
class FieldProcessingController extends AbstractController
{
    /**
     * @Route("/", name="field_processing_index", methods={"GET"})
     * @param Request                   $request
     * @param FieldProcessingRepository $fieldProcessingRepository
     *
     * @return Response
     */
    public function index(Request $request, FieldProcessingRepository $fieldProcessingRepository): Response
    {
        $qp = new QueryParamFieldProcessing();

        $data               = [];
        $data['field_id']   = "";
        $data['crop_id']    = "";
        $data['tractor_id'] = "";

        $get      = $request->query;
        $field_id = (int)$get->get("field_id");
        if ($field_id > 0) {
            $qp->field_id = $data['field_id'] = $field_id;
        }
        $crop_id = (int)$get->get("crop_id");
        if ($crop_id > 0) {
            $qp->crop_id = $data['crop_id'] = $crop_id;
        }
        $tractor_id = (int)$get->get("tractor_id");
        if ($tractor_id > 0) {
            $qp->tractor_id = $data['tractor_id'] = $tractor_id;
        }

        $data['processings'] = $fieldProcessingRepository->findByQueryParam($qp);
        $data['sum']         = $fieldProcessingRepository->sumAreaByQueryParam($qp);

        $data['crops'] = $this->getDoctrine()->getRepository(Crop::class)->findAll();;
        $data['fields'] = $this->getDoctrine()->getRepository(Field::class)->findAll();;
        $data['tractors'] = $this->getDoctrine()->getRepository(Tractor::class)->findAll();

        return $this->render('field_processing/index.html.twig', ['data' => $data]);
    }

    /**
     * @Route("/report", name="field_processing_report", methods={"GET"})
     * @param FieldProcessingRepository $fieldProcessingRepository
     *
     * @return Response
     */
    public function report(FieldProcessingRepository $fieldProcessingRepository): Response
    {
        return $this->render('field_processing/index.html.twig', [
            'field_processings' => $fieldProcessingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="field_processing_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $fieldProcessing = new FieldProcessing();
        $form            = $this->createForm(FieldProcessingType::class, $fieldProcessing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $fieldProcessing->setUser($this->getUser());
            $entityManager->persist($fieldProcessing);
            $entityManager->flush();

            return $this->redirectToRoute('field_processing_index');
        }

        return $this->render('field_processing/new.html.twig', [
            'field_processing' => $fieldProcessing,
            'form'             => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="field_processing_show", methods={"GET"})
     * @param FieldProcessing $fieldProcessing
     *
     * @return Response
     */
    public function show(FieldProcessing $fieldProcessing): Response
    {
        return $this->render('field_processing/show.html.twig', [
            'field_processing' => $fieldProcessing,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="field_processing_edit", methods={"GET","POST"})
     * @param Request         $request
     * @param FieldProcessing $fieldProcessing
     *
     * @return Response
     */
    public function edit(Request $request, FieldProcessing $fieldProcessing): Response
    {
        $form = $this->createForm(FieldProcessingType::class, $fieldProcessing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('field_processing_index', [
                'id' => $fieldProcessing->getId(),
            ]);
        }

        return $this->render('field_processing/edit.html.twig', [
            'field_processing' => $fieldProcessing,
            'form'             => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="field_processing_delete", methods={"DELETE"})
     * @param Request         $request
     * @param FieldProcessing $fieldProcessing
     *
     * @return Response
     */
    public function delete(Request $request, FieldProcessing $fieldProcessing): Response
    {
        if ($this->isCsrfTokenValid('delete' . $fieldProcessing->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fieldProcessing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('field_processing_index');
    }
}
