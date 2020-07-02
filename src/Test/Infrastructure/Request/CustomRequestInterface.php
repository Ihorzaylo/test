<?php
declare(strict_types=1);

namespace Test\Infrastructure\Request;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\Validator\Constraint;

interface CustomRequestInterface
{
    public function populate(SymfonyRequest $request): void;

    /** @return Constraint|Constraint[] */
    public function getValidationRules();

    /** @return mixed[] */
    public function getValidatableData(): array;

    /** @return mixed[] */
    public function getUnexpectedParams(): array;
}
