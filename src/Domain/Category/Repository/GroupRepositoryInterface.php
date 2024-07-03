<?php
declare(strict_types=1);

namespace App\Domain\Category\Repository;

use App\Domain\Category\Dto\GroupQuery;
use App\Domain\Category\Entity\Group;
use App\Domain\User\Entity\User;

interface GroupRepositoryInterface
{
    public function save(Group $group): void;

    public function delete(Group $group): void;

    public function search(GroupQuery $query): array;
}
