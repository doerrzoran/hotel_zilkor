<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Psr\Log\LoggerInterface;

class AccessDeniedListener
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof AccessDeniedException) {
            $this->logger->info('AccessDeniedListener triggered.');

            $response = new JsonResponse([
                'error' => 'Access Denied',
                'message' => 'You do not have the necessary permissions to access this resource.'
            ], JsonResponse::HTTP_FORBIDDEN);

            $event->setResponse($response);
        }
    }
}

