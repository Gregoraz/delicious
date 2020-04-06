<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanelController extends AbstractController
{

    /**
     * @Route("/panel", methods={"GET"}, name="app_panel_index")
     */
    public function index()
    {
        return $this->render('panel/index.html.twig');
    }

    /**
     * @Route("/panel/editprofile", methods={"GET"}, name="app_edit_profile")
     */
    public function editProfile()
    {
        return $this->render('panel/edit_profile.html.twig');
    }

    /**
     * @Route("/panel/processprofile", methods={"POST"})
     */
    public function processProfile()
    {
        return $this->redirectToRoute('app_panel_index');
    }

    /**
     * @Route("/panel/addRestaurantToFav", methods={"POST"}, name="app_panel_add_favorite")
     * @param Request $request
     */
    public function addRestaurantToFavorites(Request $request)
    {
        $restaurantID = $request->query->get('restaurantID');
        $openedTab = $request->query->get('opened_tab') ?: null;
        $user = $this->getUser();

        if($restaurantID && $user) {
            //todo add restaurant here
            //todo first do many to many in models, then add this to the fav list
        } else {
            $this->redirectToRoute('app_restaurant_details');
        }
    }


}