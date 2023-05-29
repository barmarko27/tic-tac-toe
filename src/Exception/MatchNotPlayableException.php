<?php

declare(strict_types=1);

namespace App\Exception;

use App\Enum\ErrorCodeEnum;

final class MatchNotPlayableException extends \DomainException
{
    public function __construct(string $gameStatus)
    {
        parent::__construct(message: "Cannot do another move, game it's: {$gameStatus}", code: ErrorCodeEnum::MATCH_NOT_PLAYABLE->value);
    }
}
