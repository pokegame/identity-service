<?php declare(strict_types=1);

namespace App\Entity;

use App\ValueObject\UserId;
use App\ValueObject\EmailAddress;
use App\ValueObject\HashedPassword;
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
     * @ORM\Embedded(class = "App\ValueObject\EmailAddress")
     */
    private $email;

    /**
     * @ORM\Embedded(class = "App\ValueObject\HashedPassword")
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
