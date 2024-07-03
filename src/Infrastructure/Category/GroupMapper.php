<?php
declare(strict_types=1);

namespace App\Infrastructure\Category;

use App\Domain\Category\Entity\Group;
use App\Infrastructure\ORM\Doctrine\Entity\CategoryGroup;
use App\Infrastructure\User\UserMapper;
use Doctrine\Common\Collections\ArrayCollection;

class GroupMapper
{
    public function __construct(
        private GroupRepository    $groupRepository,
        private UserMapper         $userMapper,
        private CategoryTypeMapper $categoryTypeMapper
    )
    {
    }

    public function toDoctrine(Group $group): CategoryGroup
    {
        $entity = $this->groupRepository->find($group->id);
        if (!$entity) {
            $entity = new CategoryGroup(
                $group->id,
                $this->categoryTypeMapper->toDoctrineType($group->type),
                $this->userMapper->toDoctrine($group->user),
                $group->name,
                new ArrayCollection()
            );
        }

        return $entity;
    }
}
