<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\ValueObject\UserId;
use App\ValueObject\EmailAddress;

interface UserRepositoryInterface
{
    public function add(User $user): void;

    public function get(UserId $userId): ?User;

    public function getByEmail(EmailAddress $email): ?User;

    public function nextIdentity(): UserId;
}
