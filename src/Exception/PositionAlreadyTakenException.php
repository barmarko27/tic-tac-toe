<?php

declare(strict_types=1);

namespace App\Exception;

use App\Enum\ErrorCodeEnum;

final class PositionAlreadyTakenException extends \DomainException
{
    public function __construct()
    {
        parent::__construct(message: 'Position is already taken!', code: ErrorCodeEnum::POSITION_ALREADY_TAKEN->value);
    }
}
