<?php

declare(strict_types=1);

namespace App\Type;

use App\Enum\StatusEnum;

final class MatchResumeType
{
    public ?int $status = StatusEnum::IN_PLAY->value;
    public ?string $playerWinner = null;
    public ?int $winningRow = null;
    public ?int $winningColumn = null;
    public bool $winningDiagonalLTR = false;
    public bool $winningDiagonalRTL = false;
}
