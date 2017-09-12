<?php declare(strict_types=1);

namespace App\Infrastructure\Symfony\Action;

use App\Domain\Model\UserId;
use App\Application\SignUpCommand;
use App\Application\SignUpApplicationService;
use App\Infrastructure\Symfony\Form\SignUpType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormFactoryInterface;

final class SignUp
{
    private $formFactory;
    private $signUpService;

    public function __construct(
        SignUpApplicationService $signUpService,
        FormFactoryInterface $formFactory
    )
    {
        $this->signUpService = $signUpService;
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/signup")
     * @Method("POST")
     */
    public function __invoke(Request $request): JsonResponse
    {
        $form = $this->formFactory->create(SignUpType::class);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Invalid data.'
            ], 400);
        }

        $request = $form->getData();

        $command = SignUpCommand::withData(
            UserId::generate()->toString(),
            $request->email,
            $request->password
        );

        ($this->signUpService)($command);

        return new JsonResponse([
            'success' => true,
            'message' => 'User created.'
        ], 201);
    }
}