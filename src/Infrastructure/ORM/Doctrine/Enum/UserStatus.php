<?php
declare(strict_types=1);

namespace App\Infrastructure\ORM\Doctrine\Enum;

enum UserStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Deleted = 'deleted';
}
