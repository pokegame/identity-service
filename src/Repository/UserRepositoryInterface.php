<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\ValueObject\UserId;

interface UserRepositoryInterface
{
    public function add(User $user): void;

    public function get(UserId $userId): ?User;

    public function nextIdentity(): UserId;
}
