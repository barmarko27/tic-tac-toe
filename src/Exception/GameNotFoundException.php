<?php

declare(strict_types=1);

namespace App\Exception;

use App\Enum\ErrorCodeEnum;

final class GameNotFoundException extends \DomainException
{
    public function __construct(int $gameIdProvided)
    {
        parent::__construct(message: "Game with id: {$gameIdProvided} not found!", code: ErrorCodeEnum::GAME_NOT_FOUND->value);
    }
}
