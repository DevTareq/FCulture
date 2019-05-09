<?php

namespace App\Controller\api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use App\Entity\Tractor;

/**
 * Brand controller.
 *
 * @Route("/api")
 */
class TractorApiController extends AbstractController
{
    /**
     * Lists all Tractors.
     * @FOSRest\Get("/tractors")
     *
     */
    public function getTractorsAction()
    {
        $repository = $this->getDoctrine()->getRepository(Tractor::class);

        // query for a single Product by its primary key (usually "id")
        $tractor = $repository->findall();

        return View::create($tractor, Response::HTTP_OK, []);
    }

    /**
     * Lists a Tractor.
     * @FOSRest\Get("/tractor/{id}")
     *
     */
    public function getTractorAction(Tractor $tractor)
    {
        return View::create($tractor, Response::HTTP_OK, []);
    }

    /**
     * Create Tractor.
     * @FOSRest\Post("/tractor")
     *
     */
    public function postTractorAction(Request $request)
    {
        $tractor = new Tractor();
        $tractor->setName($request->get('name'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($tractor);
        $em->flush();

        return View::create($tractor, Response::HTTP_CREATED, []);
    }
}