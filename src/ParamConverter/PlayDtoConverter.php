<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\Dto\PlayDto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class PlayDtoConverter implements ParamConverterInterface
{
    public function supports(ParamConverter $configuration): bool
    {
        return 'playDto' === $configuration->getName();
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        /**
         * @var array<string, int|string> $data
         */
        $data = json_decode($request->getContent(), true);
        $gameId = (int) ($data['gameId'] ?? null);
        $player = (string) ($data['player'] ?? null);
        $x = (int) ($data['x'] ?? null);
        $y = (int) ($data['y'] ?? null);

        if (!$gameId || !$player || !is_int($x) || !is_int($y)) {
            throw new BadRequestHttpException('Missing required fields');
        }

        try {
            $dto = new PlayDto($gameId, $player, $x, $y);
            $request->attributes->set($configuration->getName(), $dto);

            return true;
        } catch (\Throwable $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
