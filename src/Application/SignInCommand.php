<?php declare(strict_types=1);

namespace App\Application;

use App\Domain\Model\EmailAddress;
use App\Domain\Model\PlainPassword;

final class SignInCommand
{
    private $emailAddress;
    private $password;

    private function __construct(string $emailAddress, string $password)
    {
        $this->emailAddress = $emailAddress;
        $this->password = $password;
    }

    public static function withData(string $emailAddress, string $password): self
    {
        return new self($emailAddress, $password);
    }

    public function emailAddress(): EmailAddress
    {
        return EmailAddress::fromString($this->emailAddress);
    }

    public function password(): PlainPassword
    {
        return PlainPassword::fromString($this->password);
    }
}
