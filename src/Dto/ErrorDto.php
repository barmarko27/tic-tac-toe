<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class ErrorDto implements DtoInterface
{
    public function __construct(
        #[Assert\NotBlank]
        public string $message,
        public ?int $code = null,
    ) {
    }
}
