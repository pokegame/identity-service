<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Command\SignUpCommand;
use App\Repository\UserRepositoryInterface;

final class SignUpService
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(SignUpCommand $command): void
    {
        $user = User::registerWithData(
            $command->userId(),
            $command->emailAddress(),
            $command->password()
        );

        $this->userRepository->add($user);
    }
}
