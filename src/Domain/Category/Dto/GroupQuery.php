<?php
declare(strict_types=1);

namespace App\Domain\Category\Dto;

use Ramsey\Uuid\UuidInterface;

class GroupQuery
{
    public function __construct(
        public UuidInterface $userId,
    )
    {
    }
}
