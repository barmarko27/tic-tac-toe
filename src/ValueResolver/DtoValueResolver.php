<?php

declare(strict_types=1);

namespace App\ValueResolver;

use App\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class DtoValueResolver implements ValueResolverInterface
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        private ValidatorInterface $validator
    ) {
    }

    /**
     * @return array<int, DtoInterface>
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function resolve(Request $request, ArgumentMetadata $argument): array
    {
        if (
            !$argument->getType()
            || !in_array(DtoInterface::class, (array) class_implements($argument->getType()))
        ) {
            return [];
        }

        try {
            $data = Request::METHOD_GET === $request->getMethod() ? $request->attributes->all() : $request->toArray();
            /**
             * @var DtoInterface $dtoValue
             */
            $dtoValue = $this->denormalizer->denormalize($data, $argument->getType(), 'json', ['disable_type_enforcement' => true]);
        } catch (NotNormalizableValueException $e) {
            // wrong types
            throw new BadRequestHttpException($e->getMessage());
        }

        $violations = $this->validator->validate($dtoValue);
        if ($violations->count() > 0) {
            // dto is not valid
            throw new BadRequestHttpException((string) $violations->get(0)->getCode());
        }

        return [$dtoValue];
    }
}
