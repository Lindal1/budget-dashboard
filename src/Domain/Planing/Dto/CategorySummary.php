<?php
declare(strict_types=1);

namespace App\Domain\Planing\Dto;

use App\Module\Planing\Domain\Entity\Category;

class CategorySummary
{
    public function __construct(
        public readonly Category $category,
        public readonly float    $total,
        public readonly float    $average,
    )
    {
    }
}
