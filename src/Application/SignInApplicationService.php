<?php declare(strict_types=1);

namespace App\Application;

use App\Domain\Service\AuthenticationService;
use App\Domain\Model\User;

final class SignInApplicationService
{ 
    private $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function __invoke(SignInCommand $command): ?User
    {
        return $this->authenticationService->authenticate(
            $command->emailAddress(),
            $command->password()
        );
    }
}
