<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use App\Entity\User;
use App\ValueObject\UserId;
use App\ValueObject\EmailAddress;

final class UserTest extends TestCase
{
    public function testRegisterNewUser()
    {
        $userId = UserId::generate();
        $email = EmailAddress::fromString('john@smith.com');
        $password = 'p4s$woRd';

        $user = User::registerWithData($userId, $email, $password);

        $this->assertInstanceOf(User::class, $user);

        $this->assertSame($userId, $user->id());
        $this->assertSame($email, $user->email());
        $this->assertSame($password, $user->password());
    }
}
