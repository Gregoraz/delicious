<?php

namespace App\Controller;

use App\Component\PostcodeComponent;
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
        $postcode = $request->query->get('postcode');

        $restaurantRepo = $this->getDoctrine()->getRepository('App\Entity\Restaurant');
        $cuisineRepo = $this->getDoctrine()->getRepository('App\Entity\Cuisine');

        return $this->render('search/index.html.twig', [
            'postcode_input' => $postcode,
            'restaurants' => $restaurantRepo->findAll(),
            'cuisines' => $cuisineRepo->findAll()
        ]);
    }

    /**
     * @Route("/search/restaurant", methods={"GET"}, name="app_restaurant_details")
     * @param Request $request
     * @return Response
     */
    public function restaurantDetails(Request $request)
    {
        $restaurantID = (int)$request->query->get('restaurantID');
        if($restaurantID) {
            $restaurantRepo = $this->getDoctrine()->getRepository('App\Entity\Restaurant');
            return $this->render('search/restaurant_detail.html.twig', [
                'restaurant' => $restaurantRepo->findOneBy(['id' => $restaurantID]),
                'miles_away' => 420
            ]);
        } else {
            $this->forward('index');
        }

    }
}