<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use App\ValueObject\HashedPassword;

final class HashedPasswordTest extends TestCase
{
    public function testCanCreateHashedPassword()
    {
        $this->assertInstanceOf(
            HashedPassword::class,
            HashedPassword::fromString('$2y$10$.vGA1O9wmRjrwAVXD98HNOgsNpDczlqm3Jq7KnEd1rVAGv3Fykk1a')
        );
    }
}
