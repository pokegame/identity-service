<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use App\Domain\Service\AuthenticationService;
use App\Domain\Model\User;
use App\Domain\Model\UserId;
use App\Domain\Model\EmailAddress;
use App\Domain\Model\PlainPassword;
use App\Domain\Model\HashedPassword;
use App\Infrastructure\Service\DefaultPasswordEncoderService;
use App\Infrastructure\Persistence\InMemory\InMemoryUserRepository;

final class AuthenticationServiceTest extends TestCase
{
    private $authenticationService;

    public function setUp()
    {
        $userRepository = new InMemoryUserRepository();
        $passwordEncoder = new DefaultPasswordEncoderService();

        $userRepository->add(
            User::registerWithData(
                UserId::fromString('fb64b163-9113-430e-ba54-fd88d596e97e'),
                EmailAddress::fromString('jon.snow@stark.com'),
                $passwordEncoder->encodePassword(
                    PlainPassword::fromString('longclaw')
                )
            )
        );

        $this->authenticationService = new AuthenticationService(
            $userRepository,
            $passwordEncoder
        );
    }

    public function testGetUserIfTheCredentialsAreCorrect()
    {
        $user = $this->authenticationService->authenticate(
            EmailAddress::fromString('jon.snow@stark.com'),
            PlainPassword::fromString('longclaw')
        );

        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);
    }

    public function testReturnNullIfPasswordIsWrong()
    {
        $user = $this->authenticationService->authenticate(
            EmailAddress::fromString('jon.snow@stark.com'),
            PlainPassword::fromString('bastard')
        );

        $this->assertNull($user);
    }

    public function testReturnNullIfUserDoesNotExist()
    {
        $user = $this->authenticationService->authenticate(
            EmailAddress::fromString('tyrion@lannister.net'),
            PlainPassword::fromString('pimp')
        );

        $this->assertNull($user);
    }
}
