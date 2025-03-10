<?php

namespace App\EventSubscriber\Api\V1;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class ResponseSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['exceptionResponse', 400],
            ],
        ];
    }

    public function exceptionResponse(ExceptionEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
        //
        //        $error = $event->getThrowable();
        //
        //        $response = new JsonResponse([
        //            'success' => false,
        //            'code' => $error->getStatusCode(),
        //            'message' => $error->getMessage(),
        //        ], $error->getStatusCode());
        //
        //        $event->setResponse($response);
    }
}