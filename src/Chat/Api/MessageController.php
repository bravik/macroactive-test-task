<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Chat\Api;

use App\Chat\Entity\Id;
use App\Chat\UseCase;
use App\Core\Helper\FormErrorsHelper;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * @Route("/messages")
 */
class MessageController extends AbstractController
{
    private FormErrorsHelper $formErrorsHelper;


    public function __construct(FormErrorsHelper $formErrorsHelper)
    {
        $this->formErrorsHelper = $formErrorsHelper;
    }

    /** @Route("/add", methods={"POST"}) */
    public function add(Request $request, UseCase\AddMessage\Handler $handler): JsonResponse
    {
        $command = new UseCase\AddMessage\Command(Id::next());

        $form = $this->createForm(UseCase\AddMessage\Form::class, $command);
        $form->submit(
            $this->getRequestBody($request)
        );

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException("No form submitted");
        }

        if (!$form->isValid()) {
            return $this->json(
                $this->formErrorsHelper->getErrors($form),
                400
            );
        }

        try {
            $handler->handle($command);
        } catch (InvalidArgumentException $e) {
            return $this->json(
                $this->formErrorsHelper->error($e->getMessage()),
                400
            );
        }

        return new JsonResponse();
    }

    private function getRequestBody(Request $request): array
    {
        try {
            return json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            throw new BadRequestHttpException("Unparsable content");
        }
    }
}
