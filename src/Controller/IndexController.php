<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Component\PostcodeComponent;

class IndexController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(EntityManagerInterface $entityManager)
    {
        $postcodeComponent = new PostcodeComponent();
        return $this->render('index/index.html.twig', [
            'postcodes' => $postcodeComponent->getPostcodes($entityManager)
        ]);
    }
}