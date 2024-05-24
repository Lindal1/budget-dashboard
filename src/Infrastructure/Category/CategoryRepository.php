<?php
declare(strict_types=1);

namespace App\Infrastructure\Category;

use App\Domain\Category\Dto\CategoryQuery;
use App\Domain\Category\Entity\Category;
use App\Domain\Category\Repository\CategoryRepositoryInterface;
use App\Infrastructure\ORM\Doctrine\Entity\Category as DoctrineCategory;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CategoryMapper         $categoryMapping,
    )
    {
    }

    public function save(Category $category): void
    {
        $this->entityManager
            ->persist($this->categoryMapping->toDoctrine($category));
        $this->entityManager->flush();
    }

    public function delete(Category $category): void
    {
        $this->entityManager
            ->remove($this->categoryMapping->toDoctrine($category));
        $this->entityManager->flush();
    }

    public function search(CategoryQuery $query): array
    {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('c')
            ->from(DoctrineCategory::class, 'c');

        if (!empty($query->uuids)) {
            $qb->andWhere('c.id IN (:ids)')
                ->setParameter('ids', $query->uuids);
        }

        if (!empty($query->names)) {
            $qb->andWhere('c.name IN (:names)')
                ->setParameter('names', $query->names);
        }

        if (!empty($query->userUuids)) {
            $qb->andWhere('c.user IN (:userIds)')
                ->setParameter('userIds', $query->userUuids);
        }

        return array_map(
            fn(DoctrineCategory $category): Category => $this->categoryMapping->toDomain($category),
            $qb->getQuery()->getResult()
        );
    }

    public function getByUuid(UuidInterface $uuid): ?Category
    {
        return $this->categoryMapping->toDomain(
            $this->entityManager
                ->getRepository(DoctrineCategory::class)
                ->find($uuid)
        );
    }
}
