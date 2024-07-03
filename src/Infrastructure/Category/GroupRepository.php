<?php
declare(strict_types=1);

namespace App\Infrastructure\Category;

use App\Domain\Category\Dto\GroupQuery;
use App\Domain\Category\Entity\Group;
use App\Domain\Category\Repository\GroupRepositoryInterface;
use App\Infrastructure\ORM\Doctrine\Entity\Category;
use App\Infrastructure\ORM\Doctrine\Entity\CategoryGroup;
use App\Infrastructure\User\UserMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class GroupRepository extends ServiceEntityRepository implements GroupRepositoryInterface
{

    public function __construct(
        ManagerRegistry            $registry,
        private CategoryTypeMapper $categoryTypeMapper,
        private CategoryMapper     $categoryMapper,
        private UserMapper         $userMapper
    )
    {
        parent::__construct($registry, CategoryGroup::class);
    }

    public function save(Group $group): void
    {
        $doctrineGroup = $this->find($group->id);
        if ($doctrineGroup === null) {
            $doctrineGroup = new CategoryGroup(
                $group->id,
                $this->categoryTypeMapper->toDoctrineType($group->type),
                $this->userMapper->toDoctrine($group->user),
                $group->name
            );
        } else {
            $doctrineGroup->name = $group->name;
        }

        $doctrineGroup->categories->clear();

        foreach ($group->categories as $category) {
            $doctrineGroup->categories->add($this->categoryMapper->toDoctrine($category));
        }
        $this->_em->persist($doctrineGroup);
        $this->_em->flush();
    }

    public function delete(Group $group): void
    {
        $doctrineGroup = $this->find($group->id);
        $categories = $doctrineGroup->categories;
        /** @var Category $category */
        foreach ($categories as $category) {
            $category->group = null;
            $this->_em->persist($category);
        }
        $this->_em->remove($doctrineGroup);
        $this->_em->flush();
    }

    public function search(GroupQuery $query): array
    {
        $qb = $this->createQueryBuilder('g');
        $qb->select('g', 'c')
            ->leftJoin('g.categories', 'c')
            ->where('g.user = :user')
            ->setParameter('user', $query->userId);

        return $qb->getQuery()->getResult();
    }
}
