<?php

use App\Entity\User;
use Cassandra\UuidInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

interface UserRepositoryInterface
{
    public function find(UuidInterface $id): ?User;

    public function findOneByEmail(string $username): ?User;

    public function save(User $user): void;

    public function remove(User $user): void;
}

final class UserRepository implements UserRepositoryInterface
{
    private const ENTITY = User::class;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ObjectRepository
     */
    private $objectRepository;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(self::ENTITY);
    }

    public function find(UuidInterface $id): ?User
    {
        $this->entityManager->find(self::ENTITY, $id->toString());
    }

    public function findOneByEmail(string $username): ?User
    {
        return $this->objectRepository->findOneBy(['email' => $username]);
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function remove(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
