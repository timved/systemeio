<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RequestResolver implements ValueResolverInterface
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$this->supports($argument)) {
            return [];
        }

        $className = $argument->getType();
        $object = new $className($request);

        $errors = $this->validator->validate($object);

        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors->get(0)->getPropertyPath() . ' ' . $errors->get(0)->getMessage());
        }

        if ($object instanceof SelfValidatorInterface) {
            $object->validate();
        }

        yield $object;
    }

    public function supports(ArgumentMetadata $argument): bool
    {
        $type = $argument->getType();
        if (empty($type) || !class_exists($type)) {
            return false;
        }

        $reflection = new \ReflectionClass($type);
        if ($reflection->implementsInterface(RequestResolverInterface::class)) {
            return true;
        }

        return false;
    }
}
