<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\DtoInterface;
use App\Entity\EntityInterface;

interface MapperInterface
{
    public function toEntity(DtoInterface $dto): EntityInterface;

    public function toDto(EntityInterface $entity): DtoInterface;
}
