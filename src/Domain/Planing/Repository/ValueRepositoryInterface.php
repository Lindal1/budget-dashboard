<?php

namespace App\Domain\Planing\Repository;

use App\Domain\Planing\Dto\ValueQuery;
use App\Domain\Planing\Entity\Value;

interface ValueRepositoryInterface
{
    public function save(Value $value): void;

    public function delete(Value $value): void;

    /**
     * @return Value[]
     */
    public function search(ValueQuery $query): array;
}
