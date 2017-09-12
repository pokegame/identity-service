<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use App\Application\SignInApplicationService;
use App\Application\SignInCommand;
use App\Domain\Model\UserId;
use App\Domain\Model\EmailAddress;
use App\Domain\Service\AuthenticationService;

final class SignInApplicationServiceTest extends TestCase
{
    public function testSignInDelegateToAuthenticationService()
    {
        $command = SignInCommand::withData(
            'john@smith.com',
            'p4s$w0rd'
        );

        $authenticationService = $this->createMock(AuthenticationService::class);
        $authenticationService->expects($this->once())
            ->method('authenticate')
            ->with(
                $command->emailAddress(),
                $command->password()
            )
        ;

        $signInService = new SignInApplicationService($authenticationService);
        $signInService($command);
    }
}
