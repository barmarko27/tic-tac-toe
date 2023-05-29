<?php

declare(strict_types=1);

namespace App\Enum;

enum ErrorCodeEnum: int
{
    case METHOD_NOT_IMPLEMENTED = 100;
    case GAME_NOT_FOUND = 200;
    case MATCH_NOT_PLAYABLE = 300;
    case NOT_PLAYER_TURN = 400;
    case POSITION_ALREADY_TAKEN = 500;
    case PLAYER_NOT_FOUND = 600;
}
