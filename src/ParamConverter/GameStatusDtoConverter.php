<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\Dto\GameStatusDto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class GameStatusDtoConverter implements ParamConverterInterface
{
    public function supports(ParamConverter $configuration): bool
    {
        return 'gameStatusDto' === $configuration->getName();
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $gameId = (int) $request->attributes->get('gameId');

        if (!$gameId) {
            throw new BadRequestHttpException('Missing required fields gameId');
        }

        try {
            $dto = new GameStatusDto($gameId);
            $request->attributes->set($configuration->getName(), $dto);

            return true;
        } catch (\Throwable $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
