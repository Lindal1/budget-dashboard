<?php
declare(strict_types=1);

namespace App\Domain\Planing\Dto;

use App\Domain\Planing\ValueObject\Month;

class MonthSummary
{
    public function __construct(
        public readonly Month $month,
        public readonly float $balance,
        public readonly float $balancePercent,
        public readonly float $incomeSum,
        public readonly float $expenseSum,
    )
    {
    }
}
