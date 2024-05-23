<?php
declare(strict_types=1);

namespace App\Domain\Planing\Dto;

use App\Domain\Planing\ValueObject\Period;

class SummaryQuery
{
    public function __construct(
        public Period $period,
        public int    $planId,
        public int    $userId,
    )
    {
    }
}
