<?php
declare(strict_types=1);

namespace Test\Infrastructure\Request\Exception;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class RequestInterfaceException extends UnprocessableEntityHttpException
{
    public const MESSAGE = 'Wrong request class provided. Request must implement CustomRequestInterface';

    public function __construct()
    {
        parent::__construct(self::MESSAGE, null);
    }
}
