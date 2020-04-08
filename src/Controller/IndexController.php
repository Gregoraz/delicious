<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/postcodesearch", name="app_postcode_search", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function postcodeSearch(Request $request, EntityManagerInterface $entityManager)
    {
        $postcodeRequest = $request->request->get('postcode') . '%';
        $queryBuilder = $entityManager->createQueryBuilder();
        $similarPostcodes = $queryBuilder
            ->select('x.postcode', 'x.latitude', 'x.longitude')
            ->from('App\Entity\Postcodelatlng', 'x')
            ->where('x.postcode LIKE :postcodeRequest')
            ->setParameter('postcodeRequest', $postcodeRequest)
            ->orderBy('x.id', 'ASC')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult();

        $output = '';
        for($i = 0, $iMax = count($similarPostcodes); $i<$iMax; $i++) {
            $row = $similarPostcodes[$i];
            $output .= '<a style="margin-left: 2%" 
            href="javascript:writePostcode('.$i.')" 
            id="toWrite'.$i.'"
            data-lat="'.$row["latitude"].'"
            data-lng="'.$row["longitude"].'"
            name="toWrite'.$i.'" 
            value="'.$row["postcode"].'">'.$row["postcode"].'</a>
            <br>';
        }

        return $output != '' ? new JsonResponse($output) : new JsonResponse('Postcode not found!');
    }

}