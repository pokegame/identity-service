<?php declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Model\User;
use App\Domain\Model\EmailAddress;
use App\Domain\Model\PlainPassword;
use App\Domain\Model\UserRepository;

/*final*/ class AuthenticationService
{
    private $userRepository;
    private $passwordEncoder;

    public function __construct(
        UserRepository $userRepository,
        PasswordEncoder $passwordEncoder
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
