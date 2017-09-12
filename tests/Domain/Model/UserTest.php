<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use App\Domain\Model\User;
use App\Domain\Model\UserId;
use App\Domain\Model\EmailAddress;
use App\Domain\Model\HashedPassword;

final class UserTest extends TestCase
{
    public function testRegisterNewUser()
    {
        $userId = UserId::generate();
        $email = EmailAddress::fromString('john@smith.com');
        $password = HashedPassword::fromString('$2y$10$.vGA1O9wmRjrwAVXD98HNOgsNpDczlqm3Jq7KnEd1rVAGv3Fykk1a');

        $user = User::registerWithData($userId, $email, $password);

        $this->assertInstanceOf(User::class, $user);

        $this->assertSame($userId, $user->id());
        $this->assertSame($email, $user->email());
        $this->assertSame($password, $user->password());
    }
}
