<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Restaurant
 *
 * @ORM\Table(name="restaurant", indexes={@ORM\Index(name="cuisineID", columns={"cuisineID"})})
 * @ORM\Entity
 */
class Restaurant
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $image = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="lat", type="string", length=100, nullable=false)
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\Column(name="lng", type="string", length=100, nullable=false)
     */
    private $lng;

    /**
     * @var int
     *
     * @ORM\Column(name="deliveryTime", type="integer", nullable=false)
     */
    private $deliverytime;

    /**
     * @var int
     *
     * @ORM\Column(name="deliveryCost", type="integer", nullable=false)
     */
    private $deliverycost;

    /**
     * @var int
     *
     * @ORM\Column(name="minimalOrder", type="integer", nullable=false)
     */
    private $minimalorder;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=false)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=255, nullable=false)
     */
    private $mobile;

    /**
     * @var int
     *
     * @ORM\Column(name="ownerID", type="integer", nullable=false)
     */
    private $ownerid;

    /**
     * @var float
     *
     * @ORM\Column(name="actualDistance", type="float", precision=10, scale=0, nullable=false)
     */
    private $actualdistance;

    /**
     * @var \Cuisine
     *
     * @ORM\ManyToOne(targetEntity="Cuisine")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cuisineID", referencedColumnName="id")
     * })
     */
    private $cuisineid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(string $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getDeliverytime(): ?int
    {
        return $this->deliverytime;
    }

    public function setDeliverytime(int $deliverytime): self
    {
        $this->deliverytime = $deliverytime;

        return $this;
    }

    public function getDeliverycost(): ?int
    {
        return $this->deliverycost;
    }

    public function setDeliverycost(int $deliverycost): self
    {
        $this->deliverycost = $deliverycost;

        return $this;
    }

    public function getMinimalorder(): ?int
    {
        return $this->minimalorder;
    }

    public function setMinimalorder(int $minimalorder): self
    {
        $this->minimalorder = $minimalorder;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getOwnerid(): ?int
    {
        return $this->ownerid;
    }

    public function setOwnerid(int $ownerid): self
    {
        $this->ownerid = $ownerid;

        return $this;
    }

    public function getActualdistance(): ?float
    {
        return $this->actualdistance;
    }

    public function setActualdistance(float $actualdistance): self
    {
        $this->actualdistance = $actualdistance;

        return $this;
    }

    public function getCuisineid(): ?Cuisine
    {
        return $this->cuisineid;
    }

    public function setCuisineid(?Cuisine $cuisineid): self
    {
        $this->cuisineid = $cuisineid;

        return $this;
    }


}
