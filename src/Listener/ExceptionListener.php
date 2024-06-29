<?php

declare(strict_types=1);

namespace App\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = new JsonResponse([]);
        $response->setData(['error' => $exception->getMessage()]);

        if ($exception instanceof BadRequestHttpException) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}
