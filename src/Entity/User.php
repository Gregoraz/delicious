<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * User
 *
 * @ORM\Table(name="user", indexes={@ORM\Index(name="restaurantID", columns={"restaurantID"})})
 * @ORM\Entity
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface, EquatableInterface
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
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=80, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="json", length=255, nullable=false)
     */
    private $roles = [];

    /**
     * @var string
     *
     * @ORM\Column(name="hasRestaurant", type="string", length=10, nullable=false)
     */
    private $hasRestaurant;

    /**
     * @var float|null
     *
     * @ORM\Column(name="currentDistance", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $currentDistance = 'NULL';

    /**
     * @var Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Restaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="restaurantID", referencedColumnName="id")
     * })
     */
    private $restaurantId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        $this->username = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $email): self
    {
        $this->email = $email;
        $this->username = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getHasRestaurant(): ?string
    {
        return $this->hasRestaurant;
    }

    public function setHasRestaurant(string $hasRestaurant): self
    {
        $this->hasRestaurant = $hasRestaurant;

        return $this;
    }

    public function getCurrentDistance(): ?float
    {
        return $this->currentDistance;
    }

    public function setCurrentDistance(?float $currentDistance): self
    {
        $this->currentDistance = $currentDistance;

        return $this;
    }

    public function getRestaurantId(): ?Restaurant
    {
        return $this->restaurantId;
    }

    public function setRestaurantId(?Restaurant $restaurantId): self
    {
        $this->restaurantId = $restaurantId;

        return $this;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }



    public function getSalt()
    {
        return null;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }


    public function eraseCredentials()
    {
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->email !== $user->getEmail()) {
            return false;
        }

        return true;
    }


}
