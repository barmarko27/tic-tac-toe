<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enum\StatusEnum;
use App\Enum\SymbolEnum;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class GameDto implements DtoInterface
{
    /**
     * @param int                            $id
     * @param string                         $playerOne
     * @param string                         $playerTwo
     * @param string                         $status
     * @param array<int, array<int, string>> $grid
     * @param string|null                    $nextPlayer
     * @param string|null                    $winnerPlayer
     */
    public function __construct(
        #[Assert\NotBlank]
        public int $id,

        #[Assert\NotBlank]
        #[Assert\Choice(choices: [SymbolEnum::CROSS, SymbolEnum::CIRCLE], message: 'Choose a valid symbol.')]
        public string $playerOne,

        #[Assert\NotBlank]
        #[Assert\Choice(choices: [SymbolEnum::CROSS, SymbolEnum::CIRCLE], message: 'Choose a valid symbol.')]
        public string $playerTwo,

        #[Assert\NotBlank]
        #[Assert\Choice(choices: [StatusEnum::IN_PLAY, StatusEnum::DRAWN, StatusEnum::WON], message: 'Choose a valid status.')]
        public string $status,

        #[Assert\NotBlank]
        #[OA\Property(property: 'grid', type: 'json')]
        public array $grid = [],

        #[Assert\Choice(choices: [SymbolEnum::CROSS, SymbolEnum::CIRCLE], message: 'Choose a valid symbol.')]
        public ?string $nextPlayer = null,

        #[Assert\Choice(choices: [SymbolEnum::CROSS, SymbolEnum::CIRCLE], message: 'Choose a valid symbol.')]
        public ?string $winnerPlayer = null,
    ) {
    }
}
