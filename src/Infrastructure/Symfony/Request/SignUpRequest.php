<?php declare(strict_types=1);

namespace App\Infrastructure\Symfony\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class SignUpRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;

    /**
     * @Assert\NotBlank()
     */
    public $password;
}
