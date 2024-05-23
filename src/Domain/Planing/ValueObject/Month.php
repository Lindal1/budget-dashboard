<?php
declare(strict_types=1);

namespace App\Domain\Planing\ValueObject;

class Month
{
    public function __construct(
        public readonly int $month,
        public readonly int $year,
    )
    {
    }
}
