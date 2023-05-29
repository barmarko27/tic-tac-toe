<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\DtoInterface;
use App\Dto\GameDto;
use App\Entity\EntityInterface;
use App\Entity\Game;
use App\Entity\Move;
use App\Entity\Player;
use App\Enum\StatusEnum;
use App\Repository\GameRepository;
use Doctrine\Common\Collections\Collection;

final readonly class GameMapper implements MapperInterface
{
    public function __construct(private GameRepository $repository)
    {
    }

    /**
     * @param GameDto $dto
     *
     * @return Game
     */
    public function toEntity(DtoInterface $dto): EntityInterface
    {
        $game = $this->repository->find($dto->id);
        if (!$game) {
            throw new \DomainException('Game not found');
        }

        return $game;
    }

    /**
     * @param Game $entity
     *
     * @return GameDto
     *
     * @throws \Exception
     */
    public function toDto(EntityInterface $entity): DtoInterface
    {
        return new GameDto(
            (int) $entity->getId(),
            $this->getSymbolPlayerByNumber($entity->getPlayers(), 1),
            $this->getSymbolPlayerByNumber($entity->getPlayers(), 2),
            StatusEnum::cases()[$entity->getStatus()]->name,
            $this->buildGrid($entity->getMoves()),
            $entity->getNextPlayer()?->getSymbolAssigned(),
            $entity->getWinnerPlayer()?->getSymbolAssigned()
        );
    }

    /**
     * @param Collection<int, Player> $players
     */
    private function getSymbolPlayerByNumber(Collection $players, int $number): string
    {
        $player = $players->findFirst(function (int|string $index, Player $player) use ($number): bool {
            return $number === $player->getPlayerNumber();
        });

        if (!$player instanceof Player) {
            throw new \DomainException('Player not found!');
        }

        return $player->getSymbolAssigned();
    }

    /**
     * @param Collection<int, Move> $moves
     *
     * @return array<int, array<int, string>>
     */
    private function buildGrid(Collection $moves): array
    {
        return $moves->reduce(function (?array $acc, Move $move) {
            $acc[$move->getX()][$move->getY()] = $move->getPlayer()?->getSymbolAssigned();

            return $acc;
        }, []) ?? [];
    }
}
