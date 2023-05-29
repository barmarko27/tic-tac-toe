<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\DtoInterface;

interface GameServiceInterface
{
    public function process(DtoInterface $inputData): DtoInterface|null;
}
