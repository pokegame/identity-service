<?php declare(strict_types=1);

namespace App\Infrastructure\Symfony\Action;

use App\Infrastructure\Service\KeyLoaderService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PublicKey
{
    private $keyLoaderService;

    public function __construct(KeyLoaderService $keyLoaderService)
    {
        $this->keyLoaderService = $keyLoaderService;
    }

    /**
     * @Route("/public-key")
     * @Method("GET")
     */
    public function __invoke(): JsonResponse
    {
        $details = $this->keyLoaderService->getPublicKeyDetails();

        return new JsonResponse([
            'publicKey' => $details['key']
        ]);
    }
}
