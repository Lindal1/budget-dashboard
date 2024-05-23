<?php
declare(strict_types=1);

namespace App\Domain\Category\Dto;

class CategoryQuery
{
    public function __construct(
        public array $uuids = [],
        public array $names = [],
        public array $userUuids = [],
    )
    {
    }
}
