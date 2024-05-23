<?php
declare(strict_types=1);

namespace App\Domain\Planing\Entity;

use App\Domain\Category\Entity\Category;
use App\Domain\Planing\ValueObject\Month;
use Ramsey\Uuid\UuidInterface;

class Value
{
    public function __construct(
        public readonly Plan          $plan,
        public readonly Month         $month,
        public readonly Category      $category,
        public int                    $value,
    )
    {
    }
}
