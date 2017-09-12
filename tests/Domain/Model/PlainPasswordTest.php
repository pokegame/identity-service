<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use App\Domain\Model\PlainPassword;

final class PlainPasswordTest extends TestCase
{
    public function testCanCreatePlainPassword()
    {
        $password = PlainPassword::fromString('p4$sw0rd');

        $this->assertInstanceOf(PlainPassword::class, $password);
        $this->assertSame('p4$sw0rd', $password->toString());
    }
}
