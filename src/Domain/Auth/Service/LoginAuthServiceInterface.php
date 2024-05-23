<?php

namespace App\Domain\Auth\Service;

use Ramsey\Uuid\UuidInterface;

interface LoginAuthServiceInterface
{
    public function set(UuidInterface $uuid, string $login, string $password): void;

    public function find(string $login, string $password): ?UuidInterface;
}
