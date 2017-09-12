<?php declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Model\PlainPassword;
use App\Domain\Model\HashedPassword;
use App\Domain\Service\PasswordEncoder;

final class DefaultPasswordEncoderService implements PasswordEncoder
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
