<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrivacyController extends AbstractController

{
    /**
     * @Route("/privacy", name="privacy")
     */
    public function index()
    {
        return $this->render('privacy/index.html.twig');
    }
}