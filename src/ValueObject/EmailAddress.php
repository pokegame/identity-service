<?php declare(strict_types=1);

namespace App\ValueObject;

final class EmailAddress
{
    private $address;

    private function __construct(string $address)
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid email', $address));
        }

        $this->address = $address;
    }

    public static function fromString(string $address)
    {
        return new self($address);
    }

    public function toString()
    {
        return $this->address;
    }

    public function equals(EmailAddress $address)
    {
        return strtolower($this->toString()) === strtolower($address->toString());
    }
}
