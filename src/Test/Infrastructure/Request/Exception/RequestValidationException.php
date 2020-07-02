<?php
declare(strict_types=1);

namespace Test\Infrastructure\Request\Exception;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class RequestValidationException extends UnprocessableEntityHttpException
{
    public const MESSAGE = 'Request validation error';

    /** @var ConstraintViolationListInterface */
    private $errors;

    public function __construct(ConstraintViolationListInterface $errors)
    {
        parent::__construct(self::MESSAGE, null);

        $this->setErrors($errors);
    }

    public function setErrors(ConstraintViolationListInterface $errors): void
    {
        $this->errors = $errors;
    }

    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }
}
