<?php

namespace App\Domain\Category\Repository;

use App\Domain\Category\Dto\CategoryQuery;
use App\Domain\Category\Entity\Category;
use Ramsey\Uuid\UuidInterface;

interface CategoryRepositoryInterface
{
    public function save(Category $category): void;

    public function delete(Category $category): void;
    public function search(CategoryQuery $query): array;
    public function getByUuid(UuidInterface $uuid): ?Category;
}
