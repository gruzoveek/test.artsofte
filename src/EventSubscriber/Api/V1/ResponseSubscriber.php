<?php

namespace App\EventSubscriber\Api\V1;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class ResponseSubscriber implements EventSubscriberInterface
{
    public function __construct()
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                ['exceptionResponse', 400],
            ],
        ];
    }

    public function exceptionResponse(ExceptionEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $error = $event->getThrowable();

        $response = new JsonResponse([
            'status' => 'error',
            'code' => $error->getStatusCode(),
            'message' => $error->getMessage(),
        ], $error->getStatusCode());

        $event->setResponse($response);
    }
}