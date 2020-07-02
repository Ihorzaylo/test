<?php
declare(strict_types=1);

namespace Test\Infrastructure\Request\Resolver;

use Test\Infrastructure\Request\Exception\RequestInterfaceException;
use Test\Infrastructure\Request\Exception\RequestValidationException;
use Test\Infrastructure\Request\CustomRequestInterface;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * This class overrides default ArgumentValueResolver
 * and provides extra validation for CustomRequestInterface objects.
 */
class CustomRequestResolver implements ArgumentValueResolverInterface
{
    /** @var Container */
    private $container;

    /** @var ?ValidatorInterface */
    private $validator;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    private function getValidator(): ValidatorInterface
    {
        if ($this->validator === null) {
            $validator = $this->container->get('validator');

            if ($validator instanceof ValidatorInterface) {
                $this->validator = $validator;
            }
        }

        return $this->validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if ($argument->getType() === ''
            || $argument->getType() === null
            || class_exists($argument->getType()) === false
        ) {
            return false;
        }

        try {
            $reflection = new ReflectionClass($argument->getType());
        } catch (ReflectionException $e) {
            throw new $e();
        }

        return $reflection->implementsInterface(CustomRequestInterface::class);
    }

    /**
     * @throws RequestValidationException
     * @throws RequestInterfaceException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): ?\Generator
    {
        $class = $argument->getType();

        try {
            $customRequest = $this->container->get($class);
        } catch (ServiceNotFoundException $ex) {
            $customRequest = new $class();
        }

        if (!$customRequest instanceof CustomRequestInterface) {
            throw new RequestInterfaceException();
        }

        $customRequest->populate($request);

        $errors = $this->getValidator()->validate(
            $customRequest->getValidatableData(),
            $customRequest->getValidationRules()
        );

        $unexpectedParams = $customRequest->getUnexpectedParams();

        if (count($unexpectedParams) > 0) {
            foreach ($unexpectedParams as $param) {
                $errors->add(
                    new ConstraintViolation(
                        'Unexpected field in request',
                        '',
                        [],
                        $customRequest,
                        '['.$param.']',
                        'Unexpected field in request'
                    )
                );
            }
        }

        if (count($errors) > 0) {
            throw new RequestValidationException($errors);
        }

        yield $customRequest;
    }
}
