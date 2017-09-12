<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\ValueObject\UserId;
use App\ValueObject\EmailAddress;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineUserRepository implements UserRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(User::class);
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function get(UserId $id): ?User
    {
        return $this->repository->find($id);
    }

    public function getByEmail(EmailAddress $email): ?User
    {
        return $this->repository->findOneBy([
            'email.address' => $email->toString()
        ]);
    }

    public function nextIdentity(): UserId
    {
        return UserId::generate();
    }
}
