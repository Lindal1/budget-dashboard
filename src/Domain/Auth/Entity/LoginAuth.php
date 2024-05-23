<?php
declare(strict_types=1);

namespace App\Domain\Auth\Entity;

use App\Domain\Auth\Validator\UniqueLogin;
use Ramsey\Uuid\UuidInterface;

#[UniqueLogin]
class LoginAuth
{
    public function __construct(
        public UuidInterface $uuid,
        public string        $login,
        public string        $passwordHash,
    )
    {
    }
}
