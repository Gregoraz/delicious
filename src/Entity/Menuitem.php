<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menuitem
 *
 * @ORM\Table(name="menuitem", indexes={@ORM\Index(name="restaurantID", columns={"restaurantID"})})
 * @ORM\Entity
 */
class Menuitem
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
     * @var string
     *
     * @ORM\Column(name="ingredients", type="text", length=65535, nullable=false)
     */
    private $ingredients;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var int
     * @ORM\Column(name="restaurantid", type="integer", nullable=true)
     */
    private $restaurantid;

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

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients(string $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRestaurantid(): ?int
    {
        return $this->restaurantid;
    }

    public function setRestaurantid(?int $restaurantid): self
    {
        $this->restaurantid = $restaurantid;
        return $this;
    }


}
