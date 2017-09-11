<?php declare(strict_types=1);

namespace App\Service;

final class KeyLoaderService
{
    private $privateKeyPath;
    private $publicKeyPath;
    private $passphrase;

    public function __construct($privateKeyPath, $publicKeyPath, $passphrase = "")
    {
        $this->privateKeyPath = $privateKeyPath;
        $this->publicKeyPath = $publicKeyPath;
        $this->passphrase = $passphrase;
    }

    public function getPrivateKey()
    {
        return openssl_pkey_get_private($this->privateKeyPath, $this->passphrase);
    }

    public function getPublicKey()
    {
        return openssl_pkey_get_public($this->publicKeyPath);
    }

    public function getPassphrase()
    {
        return $this->passphrase;
    }
}
