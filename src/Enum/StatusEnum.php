<?php

declare(strict_types=1);

namespace App\Enum;

enum StatusEnum: int
{
    case IN_PLAY = 0;
    case DRAWN = 1;
    case WON = 2;
}
