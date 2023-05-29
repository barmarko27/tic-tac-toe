<?php

declare(strict_types=1);

namespace App\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

final class StartGameDtoConverter implements ParamConverterInterface
{
    public function supports(ParamConverter $configuration): bool
    {
        return 'startGameDto' === $configuration->getName();
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        return true;
    }
}
