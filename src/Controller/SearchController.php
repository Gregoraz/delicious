<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{

    /**
     * @Route("/search", methods={"GET"}, name="app_search")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $restaurantRepo = $this->getDoctrine()->getRepository('App\Entity\Restaurant');
        $restaurantObj = $restaurantRepo->findAll();

        $cuisineRepo = $this->getDoctrine()->getRepository('App\Entity\Cuisine');
        $cuisineObj = $cuisineRepo->findAll();

        $postcode = $request->query->get('postcode');
        return $this->render('search/index.html.twig', [
            'postcode_input' => $postcode,
            'restaurants' => $restaurantObj,
            'cuisines' => $cuisineObj
        ]);
    }

    /**
     * @Route("/search/details", methods={"GET"}, name="app_restaurant_details")
     * @param Request $request
     * @return void
     */
    public function restaurantDetails(Request $request)
    {

    }
}