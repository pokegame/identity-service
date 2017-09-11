<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use App\Repository\InMemoryUserRepository;
use App\Service\SignUpService;
use App\Command\SignUpCommand;
use App\Entity\User;
use App\ValueObject\UserId;

final class SignUpServiceTest extends TestCase
{
    private $userRepository;
    private $signInService;
    private $command;

    public function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
        $this->signInService = new SignUpService($this->userRepository);

        $this->command = SignUpCommand::withData(
            '91f13fcf-4bc5-4930-ad33-40f18edc9899',
            'john@smith.com',
            'p4s$woRd'
        );
    }

    public function testUserAddedInsideCollectionAfterSignUp()
    {
        $userId = UserId::fromString('91f13fcf-4bc5-4930-ad33-40f18edc9899');

        $this->assertNull($this->userRepository->get($userId));
        ($this->signInService)($this->command);
        $this->assertNotNull($this->userRepository->get($userId));
    }
}
