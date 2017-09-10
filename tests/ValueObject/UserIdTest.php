<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use App\ValueObject\UserId;

final class UserIdTest extends TestCase
{
    public function testCanGenerateUserId()
    {
        $this->assertInstanceOf(
            UserId::class,
            UserId::generate()
        );
    }
}
