<?php

namespace App\Controller\api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use App\Entity\Crop;

/**
 * Brand controller.
 *
 * @Route("/api")
 */
class CropApiController extends AbstractController
{
    /**
     * Lists all Crops.
     * @FOSRest\Get("/crops")
     *
     */
    public function getCropsAction()
    {
        $repository = $this->getDoctrine()->getRepository(Crop::class);

        // query for a single Product by its primary key (usually "id")
        $crop = $repository->findall();

        return View::create($crop, Response::HTTP_OK, []);
    }

    /**
     * Lists a Crop.
     * @FOSRest\Get("/crop/{id}")
     *
     */
    public function getCropAction(Crop $crop)
    {
        return View::create($crop, Response::HTTP_OK, []);
    }

    /**
     * Create Crop.
     * @FOSRest\Post("/crop")
     *
     */
    public function postCropAction(Request $request)
    {
        $crop = new Crop();
        $crop->setName($request->get('name'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($crop);
        $em->flush();

        return View::create($crop, Response::HTTP_CREATED, []);
    }
}