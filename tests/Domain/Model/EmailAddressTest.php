<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use App\Domain\Model\EmailAddress;

final class EmailAddressTest extends TestCase
{
    public function testValidEmailAddress()
    {
        $validEmail = EmailAddress::fromString('joe.smith@example.com');

        $this->assertInstanceOf(EmailAddress::class, $validEmail);
        $this->assertSame('joe.smith@example.com', $validEmail->toString());
    }

    /**
     * @dataProvider invalidEmailProvider
     */
    public function testInvalidEmailAddress($invalidEmail)
    {
        $this->expectException(\InvalidArgumentException::class);
        EmailAddress::fromString($invalidEmail);
    }

    public function invalidEmailProvider()
    {
        return [
            [''],
            ['something'],
            ['invalid@email']
        ];
    }
}
