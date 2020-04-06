<?php

namespace App\Component;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

class PostcodeComponent
{

    public function getPostcodes(EntityManager $entityManager)
    {
        $postcodeRepo = $entityManager->getRepository('App\Entity\Postcodelatlng');
        $postcodeObj = $postcodeRepo->findAll();
        $postcodeArray = [];
        foreach($postcodeObj as $obj) {
            $postcodeArray[] = [
                'id' => $obj->getId(),
                'postcode' => $obj->getPostcode(),
                'lat' => $obj->getLatitude(),
                'long' => $obj->getLongitude()
            ];
        }
        return $postcodeArray;
    }
}