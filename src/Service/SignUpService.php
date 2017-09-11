<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Command\SignUpCommand;
use App\Repository\UserRepositoryInterface;

final class SignUpService
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
