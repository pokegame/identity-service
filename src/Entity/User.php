<?php declare(strict_types=1);

namespace App\Entity;

use App\ValueObject\UserId;

final class User
{
    private $userId;
    private $email;
    private $password;

    private function __construct(UserId $userId, string $email, string $password)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->password = $password;
    }

    public static function registerWithData(UserId $userId, string $email, string $password): self
    {
        return new User($userId, $email, $password);
    }

    public function id(): UserId
    {
        return $this->userId;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
