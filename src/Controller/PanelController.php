<?php

namespace App\Controller;

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


}