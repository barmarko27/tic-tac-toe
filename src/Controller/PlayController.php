<?php

namespace App\Controller;

use App\Dto\PlayDto;
use App\Dto\ResponseDto;
use App\Service\PlayService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/game/play', name: 'play', methods: [Request::METHOD_POST])]
#[ParamConverter('playDto', converter: 'playDto')]
#[OA\Response(
    response: 200,
    description: 'Game\'s Information',
    content: new Model(type: ResponseDto::class)
)]
#[OA\Post(requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: new Model(type: PlayDto::class))))]
final class PlayController extends AbstractController
{
    public function __construct(private readonly PlayService $playService)
    {
    }

    public function __invoke(
        PlayDto $dto
    ): JsonResponse {
        return $this->json(
            new ResponseDto(
                data: $this->playService->process($dto)
            )
        );
    }
}
