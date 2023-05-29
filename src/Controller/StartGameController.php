<?php

namespace App\Controller;

use App\Dto\ResponseDto;
use App\Dto\StartGameDto;
use App\Service\StartGameService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/game/start-game', name: 'start_game', methods: [Request::METHOD_POST])]
#[OA\Response(
    response: 200,
    description: 'New Game Entity',
    content: new Model(type: ResponseDto::class)
)]
#[ParamConverter('startGameDto', converter: 'startGameDto')]
#[OA\Post(requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: new Model(type: StartGameDto::class))))]
final class StartGameController extends AbstractController
{
    public function __construct(private readonly StartGameService $startGame)
    {
    }

    public function __invoke(
        StartGameDto $dto
    ): JsonResponse {
        return $this->json(
            new ResponseDto(
                data: $this->startGame->process($dto)
            )
        );
    }
}
