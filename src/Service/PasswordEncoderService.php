<?php declare(strict_types=1);

namespace App\Service;

use App\ValueObject\PlainPassword;
use App\ValueObject\HashedPassword;

/*final*/ class PasswordEncoderService
{
    public function encodePassword(PlainPassword $password): HashedPassword
    {
        return HashedPassword::fromString(password_hash($password->toString(), PASSWORD_DEFAULT));
    }

    public function isPasswordValid(HashedPassword $hashedPassword, PlainPassword $password): bool
    {
        return password_verify($password->toString(), $hashedPassword->toString());
    } 
}
