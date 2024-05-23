<?php

namespace App\Domain\Auth\Repository;

use App\Domain\Auth\Entity\LoginAuth;
use Ramsey\Uuid\UuidInterface;

interface LoginRepositoryInterface
{
    public function save(LoginAuth $loginAuth): void;

    public function findByLogin(string $login): ?LoginAuth;
    public function findByUuid(UuidInterface $uuid): ?LoginAuth;
}