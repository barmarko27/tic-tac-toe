<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\DtoInterface;
use App\Dto\GameDto;
use App\Dto\GameStatusDto;
use App\Mapper\GameMapper;
use App\Mapper\GameStatusMapper;

final readonly class GameStatusService implements GameServiceInterface
{
    public function __construct(
        private GameMapper $gameMapper,
        private GameStatusMapper $gameStatusMapper,
    ) {
    }

    /**
     * @param GameStatusDto $inputData
     *
     * @return GameDto|null
     *
     * @throws \Exception
     */
    public function process(DtoInterface $inputData): DtoInterface|null
    {
        $game = $this->gameStatusMapper->toEntity($inputData);

        return $this->gameMapper->toDto($game);
    }
}
