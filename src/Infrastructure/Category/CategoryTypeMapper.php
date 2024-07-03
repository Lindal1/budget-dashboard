<?php
declare(strict_types=1);

namespace App\Infrastructure\Category;

use App\Domain\Category\Enum\CategoryType;
use App\Infrastructure\ORM\Doctrine\Enum\CategoryType as DoctrineCategoryType;

class CategoryTypeMapper
{
    public function toDoctrineType(CategoryType $type): DoctrineCategoryType
    {
        return match ($type) {
            CategoryType::Income => DoctrineCategoryType::Income,
            CategoryType::Expense => DoctrineCategoryType::Expense,
        };
    }

    public function toDomainType(DoctrineCategoryType $type): CategoryType
    {
        return match ($type) {
            DoctrineCategoryType::Income => CategoryType::Income,
            DoctrineCategoryType::Expense => CategoryType::Expense,
        };
    }
}
