<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class ResponseDto implements DtoInterface
{
    public function __construct(
        #[Assert\NotBlank]
        public ?DtoInterface $data = null,

        #[Assert\NotBlank]
        public ?ErrorDto $error = null,
    ) {
    }
}
