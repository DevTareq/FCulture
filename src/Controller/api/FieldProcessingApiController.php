<?php

namespace App\Controller\api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use App\Entity\FieldProcessing;
use App\Entity\Field;
use App\Entity\Crop;
use App\Entity\Tractor;

/**
 * Brand controller.
 *
 * @Route("/api")
 */
class FieldProcessingApiController extends AbstractController
{
    /**
     * Lists all FieldProcessing.
     * @FOSRest\Get("/fieldProcessings")
     *
     */
    public function getFieldProcessingsAction()
    {
        $repository = $this->getDoctrine()->getRepository(FieldProcessing::class);

        // query for a single Product by its primary key (usually "id")
        $fieldProcessing = $repository->findall();

        return View::create($fieldProcessing, Response::HTTP_OK, []);
    }

    /**
     * Get a FieldProcessing.
     * @FOSRest\Get("/fieldProcessing/{id}")
     *
     */
    public function getFieldProcessingAction(FieldProcessing $fieldProcessing)
    {
        return View::create($fieldProcessing, Response::HTTP_OK, []);
    }

    /**
     * Create FieldProcessing.
     * @FOSRest\Post("/fieldProcessing")
     *
     */
    public function postFieldProcessingAction(Request $request)
    {
        $fieldProcessing = new FieldProcessing();

        $repField = $this->getDoctrine()->getRepository(Field::class);
        $field    = $repField->find($request->get('field_id'));
        $fieldProcessing->setField($field);


        $repCrop = $this->getDoctrine()->getRepository(Crop::class);
        $crop    = $repCrop->find($request->get('crop_id'));
        $fieldProcessing->setCrop($crop);

        $repTractor = $this->getDoctrine()->getRepository(Tractor::class);
        $tractor    = $repTractor->find($request->get('tractor_id'));
        $fieldProcessing->setTractor($tractor);

        $fieldProcessing->setArea($request->get('area'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($fieldProcessing);
        $em->flush();

        return View::create($fieldProcessing, Response::HTTP_CREATED, []);
    }
}