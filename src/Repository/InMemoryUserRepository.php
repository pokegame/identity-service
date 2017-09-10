<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\ValueObject\UserId;

final class InMemoryUserRepository implements UserRepositoryInterface
{
    private $users = [];

    public function add(User $user): void
    {
        $this->users[$user->id()->toString()] = $user;
    }

    public function get(UserId $id): ?User
    {
        if (!isset($this->users[$id->toString()])) {
            return null;
        }

        return $this->users[$id->toString()];
    }

    public function nextIdentity(): UserId
    {
        return UserId::generate();
    }
}
