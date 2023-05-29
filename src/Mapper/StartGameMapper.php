<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\DtoInterface;
use App\Dto\StartGameDto;
use App\Entity\EntityInterface;
use App\Entity\Game;
use App\Entity\Player;
use App\Enum\StatusEnum;
use App\Enum\SymbolEnum;
use App\Exception\NotImplementedException;

final readonly class StartGameMapper implements MapperInterface
{
    /**
     * @param StartGameDto $dto
     *
     * @return Game
     */
    public function toEntity(DtoInterface $dto): EntityInterface
    {
        list($playerOne, $playerTwo) = $this->generatePlayers();

        $game = new Game();
        $game->addPlayer($playerOne);
        $game->addPlayer($playerTwo);
        $game->setStatus(StatusEnum::IN_PLAY->value);
        $game->setNextPlayer($playerOne);

        return $game;
    }

    /**
     * @param Game $entity
     *
     * @return StartGameDto
     *
     * @throws NotImplementedException
     */
    public function toDto(EntityInterface $entity): DtoInterface
    {
        throw new NotImplementedException('Cannot convert this entity to dto');
    }

    /**
     * @return Player[]
     */
    private function generatePlayers(): array
    {
        $playerOne = new Player();
        $playerOne->setPlayerNumber(1);
        $playerOne->setSymbolAssigned(SymbolEnum::CROSS->value);

        $playerTwo = new Player();
        $playerTwo->setPlayerNumber(2);
        $playerTwo->setSymbolAssigned(SymbolEnum::CIRCLE->value);

        return [$playerOne, $playerTwo];
    }
}
