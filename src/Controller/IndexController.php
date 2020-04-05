<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Component\PostcodeComponent;

class IndexController extends AbstractController
{

     /**
      * @Route("/")
      */
    public function index()
    {
        $postcodeComponent = new PostcodeComponent();
        return $this->render('index/index.html.twig', [
            'postcodes' => $postcodeComponent->getPostcodes()
        ]);
    }
}