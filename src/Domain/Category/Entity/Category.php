<?php
declare(strict_types=1);

namespace App\Domain\Category\Entity;

use App\Domain\Category\Enum\CategoryType;
use Ramsey\Uuid\UuidInterface;

class Category
{
    public function __construct(
        public readonly UuidInterface $uuid,
        public readonly UuidInterface $userUuid,
        public readonly CategoryType  $type,
        public string                 $name,
    )
    {
    }
}
