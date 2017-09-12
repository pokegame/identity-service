<?php declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Model\EmailAddress;
use App\Domain\Model\UserRepository;

final class ChecksUniqueUsersEmailAddress
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function alreadyExists(EmailAddress $emailAddress): bool
    {
        return $this->userRepository->getByEmail($emailAddress) !== null;
    }
}
