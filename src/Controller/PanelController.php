<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanelController extends AbstractController
{

    /**
     * @Route("/panel/", methods={"GET"})
     */
    public function index()
    {
        return $this->render('panel/index.html.twig');
    }
}