<?php

namespace App\Controller\api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use App\Entity\Field;

/**
 * Brand controller.
 *
 * @Route("/api")
 */
class FieldApiController extends AbstractController
{
    /**
     * Lists all Fields.
     * @FOSRest\Get("/fields")
     *
     */
    public function getFieldsAction()
    {
        $repository = $this->getDoctrine()->getRepository(Field::class);

        // query for a single Product by its primary key (usually "id")
        $field = $repository->findall();

        return View::create($field, Response::HTTP_OK, []);
    }

    /**
     * Get a Field.
     * @FOSRest\Get("/field/{id}")
     *
     */
    public function getFieldAction(Field $field)
    {
        return View::create($field, Response::HTTP_OK, []);
    }

    /**
     * Create Field.
     * @FOSRest\Post("/field")
     *
     */
    public function postFieldAction(Request $request)
    {
        $field = new Field();
        $field->setName($request->get('name'));
        $field->setArea($request->get('area'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($field);
        $em->flush();

        return View::create($field, Response::HTTP_CREATED, []);
    }
}