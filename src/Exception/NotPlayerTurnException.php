<?php

declare(strict_types=1);

namespace App\Exception;

use App\Enum\ErrorCodeEnum;

final class NotPlayerTurnException extends \DomainException
{
    public function __construct(string $player)
    {
        parent::__construct(message: "It's not player: {$player} round!", code: ErrorCodeEnum::NOT_PLAYER_TURN->value);
    }
}
