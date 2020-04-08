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
     * @Route("/search", methods={"GET", "POST"}, name="app_search")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $postcode = $request->request->get('postcode');
        $lat = $request->request->get('lat');
        $lng = $request->request->get('lng');

        $restaurantRepo = $this->getDoctrine()->getRepository('App\Entity\Restaurant');
        $cuisineRepo = $this->getDoctrine()->getRepository('App\Entity\Cuisine');

        return $this->render('search/index.html.twig', [
            'postcode_input' => $postcode,
            'restaurants' => $restaurantRepo->findAll(),
            'cuisines' => $cuisineRepo->findAll(),
            'userLat' => $lat,
            'userLng' => $lng
        ]);
    }

    /**
     * @Route("/search/restaurant", methods={"GET", "POST"}, name="app_restaurant_details")
     * @param Request $request
     * @return Response
     */
    public function restaurantDetails(Request $request)
    {
        $error = $request->query->get('error') ?: null;
        if($error) {
            foreach($error as &$singleError) {
                $singleError = urldecode($singleError);
            }
        }

        $menuItemsRepo = $this->getDoctrine()->getRepository('App\Entity\Menuitem');

        $restaurantID = (int)$request->request->get('restaurantID');
        $milesAray = (float)$request->request->get('miles_away');

        if($restaurantID) {
            $restaurantRepo = $this->getDoctrine()->getRepository('App\Entity\Restaurant');
            return $this->render('search/restaurant_detail.html.twig', [
                'restaurant' => $restaurantRepo->findOneBy(['id' => $restaurantID]),
                'miles_away' => $milesAray,
                'menu_items' => $menuItemsRepo->findBy(['restaurantid' => $restaurantID]),
                'error' => $error
            ]);
        } else {
            $this->forward('index');
        }
    }
}