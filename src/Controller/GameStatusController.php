<?php

namespace App\Controller;

use App\Dto\GameStatusDto;
use App\Dto\ResponseDto;
use App\Service\GameStatusService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/game/{gameId}/status', name: 'game-status', requirements: ['gameId' => '\d+'], methods: [Request::METHOD_GET])]
#[ParamConverter('gameStatusDto', converter: 'gameStatusDto')]
#[OA\Response(
    response: 200,
    description: 'Game\'s Information',
    content: new Model(type: ResponseDto::class),
)]
#[OA\Get]
final class GameStatusController extends AbstractController
{
    public function __construct(private readonly GameStatusService $gameStatusService)
    {
    }

    public function __invoke(
        GameStatusDto $dto
    ): JsonResponse {
        return $this->json(
            new ResponseDto(
                data: $this->gameStatusService->process($dto)
            )
        );
    }
}
