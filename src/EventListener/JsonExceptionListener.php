<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Dto\ErrorDto;
use App\Dto\ResponseDto;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class JsonExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $body = new ResponseDto(
            null,
            new ErrorDto(
                $exception->getMessage(),
                $exception->getCode()
            )
        );

        $response = new JsonResponse($body);

        $statusCode = match (get_class($exception)) {
            default => Response::HTTP_INTERNAL_SERVER_ERROR,
            \DomainException::class => Response::HTTP_BAD_REQUEST
        };

        $response->setStatusCode($statusCode);
        $event->setResponse($response);
    }
}
