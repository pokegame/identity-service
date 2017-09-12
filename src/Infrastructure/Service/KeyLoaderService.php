<?php declare(strict_types=1);

namespace App\Infrastructure\Service;

final class KeyLoaderService
{
    private $privateKeyPath;
    private $publicKeyPath;
    private $passphrase;

    public function __construct(string $privateKeyPath, string $publicKeyPath, string $passphrase = "")
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

    public function getPublicKeyDetails(): array
    {
        return openssl_pkey_get_details($this->getPublicKey());
    }

    public function getPassphrase()
    {
        return $this->passphrase;
    }
}
