<?php declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Model\PlainPassword;
use App\Domain\Model\HashedPassword;

interface PasswordEncoder
{
    public function encodePassword(PlainPassword $password): HashedPassword;

    public function isPasswordValid(HashedPassword $hashedPassword, PlainPassword $password): bool;
}
