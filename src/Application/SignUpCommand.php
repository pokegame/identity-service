<?php declare(strict_types=1);

namespace App\Application;

use App\Domain\Model\UserId;
use App\Domain\Model\EmailAddress;
use App\Domain\Model\PlainPassword;

final class SignUpCommand
{
    private $userId;
    private $emailAddress;
    private $password;

    private function __construct(string $userId, string $emailAddress, string $password)
    {
        $this->userId = $userId;
        $this->emailAddress = $emailAddress;
        $this->password = $password;
    }

    public static function withData(string $userId, string $emailAddress, string $password): self
    {
        return new self($userId, $emailAddress, $password);
    }

    public function userId(): UserId
    {
        return UserId::fromString($this->userId);
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
