<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Model\User;
use App\Domain\Model\UserId;
use App\Domain\Model\EmailAddress;
use App\Domain\Model\UserRepository;

final class InMemoryUserRepository implements UserRepository
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

    public function getByEmail(EmailAddress $email): ?User
    {
        foreach ($this->users as $user) {
            if ($user->email()->equals($email)) {
                return $user;
            }
        }

        return null;
    }

    public function nextIdentity(): UserId
    {
        return UserId::generate();
    }
}
