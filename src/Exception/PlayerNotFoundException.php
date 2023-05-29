<?php

declare(strict_types=1);

namespace App\Exception;

use App\Enum\ErrorCodeEnum;

final class PlayerNotFoundException extends \DomainException
{
    public function __construct(int $playerNumberProvided)
    {
        parent::__construct(message: "Player number: {$playerNumberProvided} not found!", code: ErrorCodeEnum::GAME_NOT_FOUND->value);
    }
}
