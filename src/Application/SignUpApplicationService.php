<?php declare(strict_types=1);

namespace App\Application;

use App\Domain\Model\User;
use App\Domain\Model\UserRepository;
use App\Domain\Service\PasswordEncoder;

final class SignUpApplicationService
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

    public function __invoke(SignUpCommand $command): void
    {
        $user = User::registerWithData(
            $command->userId(),
            $command->emailAddress(),
            $this->passwordEncoder->encodePassword(
                $command->password()
            )
        );

        $this->userRepository->add($user);
    }
}
