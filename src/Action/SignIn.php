<?php declare(strict_types=1);

namespace App\Action;

use App\Form\SignInType;
use App\Service\AuthenticationService;
use App\Service\JWTEncoderService;
use App\ValueObject\EmailAddress;
use App\ValueObject\PlainPassword;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormFactoryInterface;

final class SignIn
{
    private $formFactory;
    private $authenticationService;
    private $jwtEncoderService;

    public function __construct(
        FormFactoryInterface $formFactory,
        AuthenticationService $authenticationService,
        JWTEncoderService $jwtEncoderService
    )
    {
        $this->formFactory = $formFactory;
        $this->authenticationService = $authenticationService;
        $this->jwtEncoderService = $jwtEncoderService;
    }

    /**
     * @Route("/signin")
     * @Method("POST")
     */
    public function __invoke(Request $request): JsonResponse
    {
        $form = $this->formFactory->create(SignInType::class);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return new JsonResponse([
                'message' => 'Bad request.'
            ], 400);
        }

        $request = $form->getData();

        $user = $this->authenticationService->authenticate(
            EmailAddress::fromString($request->email),
            PlainPassword::fromString($request->password)
        );

        if ($user === null) {
            return new JsonResponse([
                'message' => 'User not found.'
            ], 404);
        }

        $token = $this->jwtEncoderService->encode([
            'user_email' => $user->email()->toString()
        ]);

        return new JsonResponse([
            'token' => $token
        ]);
    }
}
