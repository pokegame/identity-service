<?php declare(strict_types=1);

namespace App\Domain\Model;

interface UserRepository
{
    public function add(User $user): void;

    public function get(UserId $userId): ?User;

    public function getByEmail(EmailAddress $email): ?User;

    public function nextIdentity(): UserId;
}
