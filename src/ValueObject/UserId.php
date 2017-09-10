<?php declare(strict_types=1);

namespace App\ValueObject;

use Ramsey\Uuid\Uuid;

final class UserId
{
    private $uuid;

    public static function generate()
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString($userId)
    {
        return new self(Uuid::fromString($userId));
    }

    private function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    public function equals(UserId $other)
    {
        return $this->toString() === $other->toString();
    }

    public function toString()
    {
        return $this->uuid->toString();
    }
}
