<?php

namespace App\Domain\Planing\Repository;

use App\Domain\Planing\Entity\Plan;
use Ramsey\Uuid\UuidInterface;

interface PlanRepositoryInterface
{
    public function save(Plan $plan): void;

    public function delete(Plan $plan): void;

    public function getByUuid(UuidInterface $uuid): ?Plan;

    public function getByUserUuid(UuidInterface $userUuid): array;
}
