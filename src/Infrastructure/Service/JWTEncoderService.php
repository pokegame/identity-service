<?php declare(strict_types=1);

namespace App\Infrastructure\Service;

use Namshi\JOSE\JWS; 

final class JWTEncoderService
{
    private $keyLoader;
    private $cryptoEngine;
    private $signatureAlgorithm;
    private $ttl;

    public function __construct(KeyLoaderService $keyLoader, $cryptoEngine, $signatureAlgorithm, $ttl = null)
    {
        $this->keyLoader = $keyLoader;
        $this->cryptoEngine = $cryptoEngine;
        $this->signatureAlgorithm = $signatureAlgorithm;
        $this->ttl = $ttl;
    }

    public function encode(array $payload): string
    {
        $jws = new JWS(['alg' => $this->signatureAlgorithm], $this->cryptoEngine);
        $claims = ['iat' => time()];

        if (null !== $this->ttl) {
            $claims['exp'] = time() + $this->ttl;
        }

        $jws->setPayload($payload + $claims);

        $jws->sign(
            $this->keyLoader->getPrivateKey(),
            $this->keyLoader->getPassphrase()
        );

        return $jws->getTokenString();
    }
}
