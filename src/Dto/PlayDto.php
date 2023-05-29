<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enum\SymbolEnum;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class PlayDto implements DtoInterface
{
    public function __construct(
        #[Assert\NotBlank]
        public int $gameId,

        #[Assert\NotBlank]
        #[Assert\Choice(choices: [SymbolEnum::CROSS->value, SymbolEnum::CIRCLE->value], message: 'Choose a valid symbol.')]
        public string $player,

        #[Assert\NotBlank]
        #[Assert\Range(
            notInRangeMessage: '"x" position must be between {{ min }} and {{ max }}',
            min: 0,
            max: 2,
        )]
        public int $x,

        #[Assert\NotBlank]
        #[Assert\Range(
            notInRangeMessage: '"y" position must be between {{ min }} and {{ max }}',
            min: 0,
            max: 2,
        )]
        public int $y,
    ) {
    }
}
