<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\DtoInterface;
use App\Dto\GameDto;
use App\Dto\StartGameDto;
use App\Mapper\GameMapper;
use App\Mapper\StartGameMapper;
use Doctrine\ORM\EntityManagerInterface;

final readonly class StartGameService implements GameServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private GameMapper $gameMapper,
        private StartGameMapper $startGameMapper,
    ) {
    }

    /**
     * @param StartGameDto $inputData
     *
     * @return GameDto|null
     *
     * @throws \Exception
     */
    public function process(DtoInterface $inputData): DtoInterface|null
    {
        $game = $this->startGameMapper->toEntity($inputData);

        $this->entityManager->persist($game);
        $this->entityManager->flush();

        return $this->gameMapper->toDto($game);
    }
}
