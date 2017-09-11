<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\ValueObject\EmailAddress;
use App\ValueObject\PlainPassword;
use App\Repository\UserRepositoryInterface;

final class AuthenticationService
{
    private $userRepository;
    private $passwordEncoder;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PasswordEncoderService $passwordEncoder
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function authenticate(EmailAddress $email, PlainPassword $password): ?User
    {
        $user = $this->userRepository->getByEmail($email);

        if ($user === null) {
            return null;
        }

        if (!$this->passwordEncoder->isPasswordValid($user->password(), $password)) {
            return null;
        }

        return $user;
    }
}
