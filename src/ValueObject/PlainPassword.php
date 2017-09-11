<?php declare(strict_types=1);

namespace App\ValueObject;

final class PlainPassword
{
    private $password;

    private function __construct(string $password)
    {
        if (empty($password)) {
            throw new \InvalidArgumentException('Password can not be empty');
        }

        $this->password = $password;
    }

    public static function fromString(string $password): self
    {
        return new self($password);
    }

    public function toString(): string
    {
        return $this->password;
    }

    public function equals(PlainPassword $password): bool
    {
        return $this->toString() === $password->toString();
    }
}
