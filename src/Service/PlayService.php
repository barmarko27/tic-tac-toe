<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\DtoInterface;
use App\Dto\GameDto;
use App\Dto\PlayDto;
use App\Entity\Game;
use App\Entity\Move;
use App\Entity\Player;
use App\Enum\StatusEnum;
use App\Enum\SymbolEnum;
use App\Exception\GameNotFoundException;
use App\Exception\MatchNotPlayableException;
use App\Exception\NotPlayerTurnException;
use App\Exception\PositionAlreadyTakenException;
use App\Mapper\GameMapper;
use App\Type\MatchResumeType;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

final readonly class PlayService implements GameServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private GameMapper $gameMapper,
    ) {
    }

    /**
     * @param PlayDto $inputData
     *
     * @return GameDto|null
     *
     * @throws \Exception
     */
    public function process(DtoInterface $inputData): DtoInterface|null
    {
        $game = $this->entityManager->find(Game::class, $inputData->gameId);

        if (!$game) {
            throw new GameNotFoundException($inputData->gameId);
        }

        if (StatusEnum::IN_PLAY->value !== $game->getStatus()) {
            $gameStatus = StatusEnum::cases()[$game->getStatus()]->name;
            throw new MatchNotPlayableException($gameStatus);
        }

        if ($game->getNextPlayer()?->getSymbolAssigned() !== $inputData->player) {
            throw new NotPlayerTurnException($inputData->player);
        }

        $move = $this->createMove($game, $inputData);
        $game->addMove($move);

        $matchResume = $this->getMatchResume($game->getMoves());
        if (StatusEnum::IN_PLAY->value === $matchResume->status) {
            $game->setNextPlayer(
                $game->getPlayers()->findFirst(function (int $index, Player $player) use ($inputData): bool {
                    return $player->getSymbolAssigned() !== $inputData->player;
                })
            );
        } else {
            if (StatusEnum::WON->value === $matchResume->status) {
                $game->setWinnerPlayer(
                    $game->getPlayers()->findFirst(function (int $index, Player $player) use ($matchResume): bool {
                        return $player->getSymbolAssigned() === $matchResume->playerWinner;
                    })
                );
            }
            $game->setNextPlayer(); // No next player if match is won or drawn
        }

        $game->setStatus((int) $matchResume->status);
        $this->entityManager->flush();

        return $this->gameMapper->toDto($game);
    }

    /**
     * @param PlayDto $inputData
     */
    private function createMove(Game $game, DtoInterface $inputData): Move
    {
        $placeIsTaken = $game->getMoves()->findFirst(function (int $index, Move $move) use ($inputData): bool {
            return $move->getX() === $inputData->x && $move->getY() === $inputData->y;
        });
        if ($placeIsTaken) {
            throw new PositionAlreadyTakenException();
        }

        $player = $game->getPlayers()->findFirst(function (int $x, Player $player) use ($inputData): bool {
            return $player->getSymbolAssigned() === $inputData->player;
        });

        $move = new Move();
        $move->setX($inputData->x);
        $move->setY($inputData->y);
        $move->setPlayer($player);

        return $move;
    }

    /**
     * @param Collection<integer, Move> $moves
     */
    private function getMatchResume(Collection $moves): MatchResumeType
    {
        $result = new MatchResumeType();

        $rows = array_fill(0, 3, [
            SymbolEnum::CROSS->value => 0,
            SymbolEnum::CIRCLE->value => 0,
        ]);
        $columns = array_fill(0, 3, [
            SymbolEnum::CROSS->value => 0,
            SymbolEnum::CIRCLE->value => 0,
        ]);
        // Left to Right Diagonal
        $diagonalLTR = [
            SymbolEnum::CROSS->value => 0,
            SymbolEnum::CIRCLE->value => 0,
        ];
        // Right to Left Diagonal
        $diagonalRTL = [
            SymbolEnum::CROSS->value => 0,
            SymbolEnum::CIRCLE->value => 0,
        ];
        foreach ($moves as $move) {
            $symbol = $move->getPlayer()?->getSymbolAssigned();

            $rows[$move->getX()][$symbol] = $rows[$move->getX()][$symbol] + 1;
            $columns[$move->getY()][$symbol] = $columns[$move->getY()][$symbol] + 1;

            $delta = $move->getY() - $move->getX();
            // If delta between axis is 0, we are in the ltr diagonal or in the middle of the grid
            if (0 === $delta) {
                $diagonalLTR[$symbol] = $diagonalLTR[$symbol] + 1;
                // In this case we have the center of the grid and the position is valid for both diagonals.
                if (1 === $move->getY() && 1 === $move->getX()) {
                    $diagonalRTL[$symbol] = $diagonalRTL[$symbol] + 1;
                }
            }
            if (2 === $delta || -2 === $delta) {
                $diagonalRTL[$symbol] = $diagonalRTL[$symbol] + 1;
            }
        }
        foreach ($rows as $row => $symbols) {
            foreach ($symbols as $symbol => $counter) {
                if (3 === $counter) {
                    $result->status = StatusEnum::WON->value;
                    $result->playerWinner = $symbol;
                    $result->winningRow = (int) $row;

                    return $result;
                }
            }
        }

        foreach ($columns as $column => $symbols) {
            foreach ($symbols as $symbol => $counter) {
                if (3 === $counter) {
                    $result->status = StatusEnum::WON->value;
                    $result->playerWinner = $symbol;
                    $result->winningColumn = (int) $column;

                    return $result;
                }
            }
        }

        foreach ($diagonalLTR as $symbol => $counter) {
            if (3 === $counter) {
                $result->status = StatusEnum::WON->value;
                $result->playerWinner = $symbol;
                $result->winningDiagonalLTR = true;

                return $result;
            }
        }

        foreach ($diagonalRTL as $symbol => $counter) {
            if (3 === $counter) {
                $result->status = StatusEnum::WON->value;
                $result->playerWinner = $symbol;
                $result->winningDiagonalRTL = true;

                return $result;
            }
        }

        if (9 === $moves->count()) {
            $result->status = StatusEnum::DRAWN->value;
        }

        return $result;
    }
}
