<?php
declare(strict_types=1);

namespace App\Infrastructure\Category;

use App\Domain\Category\Entity\Category;
use App\Domain\Category\Enum\CategoryType;
use App\Infrastructure\ORM\Doctrine\Entity\Category as DoctrineCategory;
use App\Infrastructure\ORM\Doctrine\Entity\User;
use App\Infrastructure\ORM\Doctrine\Enum\CategoryType as DoctrineCategoryType;
use Doctrine\ORM\EntityManagerInterface;

class CategoryMapper
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    private function toDoctrineType(CategoryType $type): DoctrineCategoryType
    {
        return match ($type) {
            CategoryType::Income => DoctrineCategoryType::Income,
            CategoryType::Expense => DoctrineCategoryType::Expense,
        };
    }

    private function toDomainType(DoctrineCategoryType $type): CategoryType
    {
        return match ($type) {
            DoctrineCategoryType::Income => CategoryType::Income,
            DoctrineCategoryType::Expense => CategoryType::Expense,
        };
    }

    public function toDoctrine(Category $category): DoctrineCategory
    {
        $doctrineCategory = $this->entityManager
            ->find(DoctrineCategory::class, $category->uuid);
        $user = $this->entityManager
            ->find(User::class, $category->userUuid);
        if (!$doctrineCategory) {
            return new DoctrineCategory(
                $category->uuid,
                $user,
                $this->toDoctrineType($category->type),
                $category->name,
            );
        }

        $doctrineCategory->name = $category->name;
        $doctrineCategory->type = $this->toDoctrineType($category->type);
        $doctrineCategory->user = $user;

        return $doctrineCategory;
    }

    public function toDomain(DoctrineCategory $doctrineCategory): Category
    {
        return new Category(
            $doctrineCategory->uuid,
            $doctrineCategory->user->uuid,
            $this->toDomainType($doctrineCategory->type),
            $doctrineCategory->name,
        );
    }
}
