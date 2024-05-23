<?php
declare(strict_types=1);

namespace App\Domain\User\Enum;

enum UserStatus
{
    case Active;
    case Inactive;
    case Deleted;
}
