<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use App\Repository\InMemoryUserRepository;
use App\Service\PasswordEncoderService;
use App\Service\AuthenticationService;
use App\Entity\User;
use App\ValueObject\UserId;
use App\ValueObject\EmailAddress;
use App\ValueObject\PlainPassword;
use App\ValueObject\HashedPassword;

final class AuthenticationServiceTest extends TestCase
{
    private $userRepository;
    private $passwordEncoderService;
    private $authenticationService;

    public function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
        $this->passwordEncoderService = new PasswordEncoderService();

        $this->userRepository->add(
            User::registerWithData(
                UserId::fromString('fb64b163-9113-430e-ba54-fd88d596e97e'),
                EmailAddress::fromString('jon.snow@stark.com'),
                $this->passwordEncoderService->encodePassword(
                    PlainPassword::fromString('longclaw')
                )
            )
        );

        $this->authenticationService = new AuthenticationService(
            $this->userRepository,
            $this->passwordEncoderService
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
