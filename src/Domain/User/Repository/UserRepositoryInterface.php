<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Dto\UserQuery;
use App\Domain\User\Entity\User;
use Ramsey\Uuid\UuidInterface;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function delete(User $user): void;

    public function search(UserQuery $query): array;

    public function get(UuidInterface $uuid): ?User;

    public function getByEmail(string $email): ?User;
}
