<?php

declare(strict_types=1);

namespace App\Exception;

use App\Enum\ErrorCodeEnum;

final class NotImplementedException extends \BadMethodCallException
{
    public function __construct(string $message)
    {
        parent::__construct(message: $message, code: ErrorCodeEnum::METHOD_NOT_IMPLEMENTED->value);
    }
}
