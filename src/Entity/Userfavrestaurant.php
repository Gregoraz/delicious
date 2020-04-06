<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Userfavrestaurant
 *
 * @ORM\Table(name="userfavrestaurant", indexes={@ORM\Index(name="userID_2", columns={"userID"}), @ORM\Index(name="userID", columns={"id", "userID"}), @ORM\Index(name="restaurantID", columns={"restaurantID"})})
 * @ORM\Entity
 */
class Userfavrestaurant
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userID", referencedColumnName="id")
     * })
     */
    private $userid;

    /**
     * @var \Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Restaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="restaurantID", referencedColumnName="id")
     * })
     */
    private $restaurantid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserid(): ?User
    {
        return $this->userid;
    }

    public function setUserid(?User $userid): self
    {
        $this->userid = $userid;

        return $this;
    }

    public function getRestaurantid(): ?Restaurant
    {
        return $this->restaurantid;
    }

    public function setRestaurantid(?Restaurant $restaurantid): self
    {
        $this->restaurantid = $restaurantid;

        return $this;
    }


}
