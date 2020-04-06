<?php

namespace App\Component;

use App\Entity\Postcodelatlng;
use Doctrine\ORM\EntityManager;

class PostcodeComponent
{

    public function getPostcodes(EntityManager $entityManager)
    {
        $postcodeRepo = $entityManager->getRepository('App\Entity\Postcodelatlng');
        $postcodeObj = $postcodeRepo->findAll();
        $postcodeArray = [];
        foreach ($postcodeObj as $obj) {
            $postcodeArray[] = [
                'id' => $obj->getId(),
                'postcode' => $obj->getPostcode(),
                'lat' => $obj->getLatitude(),
                'long' => $obj->getLongitude()
            ];
        }
        return $postcodeArray;
    }

    public function getPostcodeByPostcode(EntityManager $entityManager, $postcode)
    {
        $postcodeRepo = $entityManager->getRepository('App\Entity\Postcodelatlng');
        return $postcodeRepo->findOneBy(['postcode' => $postcode]);
    }
}