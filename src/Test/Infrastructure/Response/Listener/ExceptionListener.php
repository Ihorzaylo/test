<?php
declare(strict_types=1);

namespace Test\Infrastructure\Response\Listener;

use Test\Infrastructure\Response\XMLResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 * Class ExceptionListener
 * @package Test\Infrastructure\Response\Listener
 */
class ExceptionListener
{
    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        $event->setResponse(XMLResponse::error());
    }
}