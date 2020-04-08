<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension implements ExtensionInterface
{
    public function getFunctions()
    {
        return [
            new TwigFunction('distance', [$this, 'calculateDistance']),
        ];
    }

    public function calculateDistance($userLat, $userLng, $restaurantLat, $restaurantLng, $unit = 'M')
    {
        $theta = $userLng - $restaurantLng;
        $dist = sin(deg2rad($userLat)) * sin(deg2rad($restaurantLat)) + cos(deg2rad($userLat)) * cos(deg2rad($restaurantLat)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}