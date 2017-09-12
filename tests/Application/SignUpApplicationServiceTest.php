<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use App\Application\SignUpApplicationService;
use App\Application\SignUpCommand;
use App\Domain\Model\User;
use App\Domain\Model\UserId;
use App\Domain\Model\HashedPassword;
use App\Domain\Service\PasswordEncoder;
use App\Infrastructure\Persistence\InMemory\InMemoryUserRepository;

final class SignUpApplicationServiceTest extends TestCase
{
    private $userRepository;
    private $passwordEncoder;
    private $signUpService;
    private $command;

    public function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
        $this->passwordEncoder = $this->createMock(PasswordEncoder::class);

        $this->signUpService = new SignUpApplicationService(
            $this->userRepository,
            $this->passwordEncoder
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
        ($this->signUpService)($this->command);
        $this->assertNotNull($this->userRepository->get($userId));
    }

    public function testSignUpServiceEncodePassword()
    {
        $expectedHash = HashedPassword::fromString('expectedHash');
        $this->passwordEncoder->method('encodePassword')
             ->willReturn($expectedHash);
        
        ($this->signUpService)($this->command);

        $user = $this->userRepository->get(UserId::fromString('91f13fcf-4bc5-4930-ad33-40f18edc9899'));
        $this->assertSame($expectedHash, $user->password());
    }
}