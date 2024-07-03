<?php
declare(strict_types=1);

namespace App\Infrastructure\Category;

use App\Domain\Category\Entity\Category;
use App\Infrastructure\ORM\Doctrine\Entity\Category as DoctrineCategory;
use App\Infrastructure\ORM\Doctrine\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CategoryMapper
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CategoryTypeMapper     $categoryTypeMapper,
    )
    {
    }

    public function toDoctrine(Category $category): DoctrineCategory
    {
        $doctrineCategory = $this->entityManager
            ->find(DoctrineCategory::class, $category->uuid);
        $user = $this->entityManager
            ->find(User::class, $category->userId);
        if (!$doctrineCategory) {
            return new DoctrineCategory(
                $category->uuid,
                $user,
                $this->categoryTypeMapper->toDoctrineType($category->type),
                $category->name,
            );
        }

        $doctrineCategory->name = $category->name;
        $doctrineCategory->type = $this->categoryTypeMapper->toDoctrineType($category->type);
        $doctrineCategory->user = $user;

        return $doctrineCategory;
    }

    public function toDomain(DoctrineCategory $doctrineCategory): Category
    {
        return new Category(
            $doctrineCategory->uuid,
            $doctrineCategory->user->uuid,
            $this->categoryTypeMapper->toDomainType($doctrineCategory->type),
            $doctrineCategory->name,
        );
    }
}
