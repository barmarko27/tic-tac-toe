<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\DtoInterface;
use App\Dto\GameStatusDto;
use App\Entity\EntityInterface;
use App\Entity\Game;
use App\Exception\GameNotFoundException;
use App\Exception\NotImplementedException;
use App\Repository\GameRepository;

final readonly class GameStatusMapper implements MapperInterface
{
    public function __construct(private GameRepository $repository)
    {
    }

    /**
     * @param GameStatusDto $dto
     *
     * @return Game
     */
    public function toEntity(DtoInterface $dto): EntityInterface
    {
        $game = $this->repository->find($dto->gameId);
        if (!$game) {
            throw new GameNotFoundException($dto->gameId);
        }

        return $game;
    }

    /**
     * @param Game $entity
     *
     * @return GameStatusDto
     *
     * @throws \Exception
     */
    public function toDto(EntityInterface $entity): DtoInterface
    {
        throw new NotImplementedException('Cannot convert this entity to dto');
    }
}
