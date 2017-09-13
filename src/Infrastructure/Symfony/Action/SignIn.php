<?php declare(strict_types=1);

namespace App\Infrastructure\Symfony\Action;

use App\Application\SignInCommand;
use App\Application\SignInApplicationService;
use App\Infrastructure\Symfony\Form\SignInType;
use App\Infrastructure\Service\JWTEncoderService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormFactoryInterface;

final class SignIn
{
    private $signInService;
    private $formFactory;
    private $jwtEncoderService;

    public function __construct(
        SignInApplicationService $signInService,
        FormFactoryInterface $formFactory,
        JWTEncoderService $jwtEncoderService
    )
    {
        $this->signInService = $signInService;
        $this->formFactory = $formFactory;
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


        $command = SignInCommand::withData(
            $request->email,
            $request->password
        );

        $user = ($this->signInService)($command);

        if ($user === null) {
            return new JsonResponse([
                'message' => 'User not found.'
            ], 404);
        }

        $token = $this->jwtEncoderService->encode([
            'user_id' => $user->id()->toString(),
            'user_email' => $user->email()->toString()
        ]);

        return new JsonResponse([
            'token' => $token
        ]);
    }
}
