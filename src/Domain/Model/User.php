<?php declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "user_id")
     */
    private $userId;

    /**
     * @ORM\Embedded(class = "EmailAddress")
     */
    private $email;

    /**
     * @ORM\Embedded(class = "HashedPassword")
     */
    private $password;

    private function __construct(UserId $userId, EmailAddress $email, HashedPassword $password)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->password = $password;
    }

    public static function registerWithData(UserId $userId, EmailAddress $email, HashedPassword $password): self
    {
        return new User($userId, $email, $password);
    }

    public function id(): UserId
    {
        return $this->userId;
    }

    public function email(): EmailAddress
    {
        return $this->email;
    }

    public function password(): HashedPassword
    {
        return $this->password;
    }
}
