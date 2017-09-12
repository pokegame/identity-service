<?php declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Embeddable 
 */
/*final*/ class HashedPassword
{
    /**
     * @ORM\Column(type = "string")
     */
    private $hash;

    private function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    public static function fromString(string $hash): self
    {
        return new self($hash);
    }

    public function toString(): string
    {
        return $this->hash;
    }

    public function equals(HashedPassword $password): bool
    {
        return $this->toString() === $password->toString();
    }
}
