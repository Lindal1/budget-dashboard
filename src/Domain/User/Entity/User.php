<?php
declare(strict_types=1);

namespace App\Domain\User\Entity;

use App\Domain\User\Enum\UserStatus;
use Ramsey\Uuid\UuidInterface;

class User
{
    public function __construct(
        public readonly UuidInterface $uuid,
        public string                 $email,
        public UserStatus             $status,
    )
    {
    }
}
