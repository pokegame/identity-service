<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use App\Repository\InMemoryUserRepository;
use App\Service\SignUpService;
use App\Service\PasswordEncoderService;
use App\Command\SignUpCommand;
use App\Entity\User;
use App\ValueObject\UserId;
use App\ValueObject\HashedPassword;

final class SignUpServiceTest extends TestCase
{
    private $userRepository;
    private $passwordEncoderService;
    private $signInService;
    private $command;

    public function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
        $this->passwordEncoderService = $this->createMock(PasswordEncoderService::class);

        $this->signInService = new SignUpService(
            $this->userRepository,
            $this->passwordEncoderService
        );

        $this->command = SignUpCommand::withData(
            '91f13fcf-4bc5-4930-ad33-40f18edc9899',
            'john@smith.com',
            'p4s$w0rd'
        );
    }

    public function testUserAddedInsideCollectionAfterSignUp()
    {
        $userId = UserId::fromString('91f13fcf-4bc5-4930-ad33-40f18edc9899');

        $this->assertNull($this->userRepository->get($userId));
        ($this->signInService)($this->command);
        $this->assertNotNull($this->userRepository->get($userId));
    }

    public function testSignInServiceEncodePassword()
    {
        $expectedHash = HashedPassword::fromString('expectedHash');
        $this->passwordEncoderService->method('encodePassword')
             ->willReturn($expectedHash);
        
        ($this->signInService)($this->command);

        $user = $this->userRepository->get(UserId::fromString('91f13fcf-4bc5-4930-ad33-40f18edc9899'));
        $this->assertSame($expectedHash, $user->password());
    }
}
