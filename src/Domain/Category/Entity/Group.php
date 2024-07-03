<?php
declare(strict_types=1);

namespace App\Domain\Category\Entity;

use App\Domain\Category\Enum\CategoryType;
use App\Domain\User\Entity\User;
use Ramsey\Uuid\UuidInterface;

class Group
{
    /**
     * @param Category[] $categories
     */
    public function __construct(
        public readonly UuidInterface $id,
        public readonly User          $user,
        public readonly CategoryType  $type,
        public string                 $name,
        public array                  $categories = []
    )
    {
    }
}
