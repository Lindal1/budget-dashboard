<?php

namespace App\Domain\Planing\Service;

use App\Domain\Planing\Dto\CategorySummary;
use App\Domain\Planing\Dto\MonthSummary;
use App\Domain\Planing\Dto\SummaryQuery;

interface SummaryCalculatorInterface
{
    /**
     * @return CategorySummary[]
     */
    public function calculateCategoriesByPeriod(SummaryQuery $filter): array;

    /**
     * @return MonthSummary[]
     */
    public function calculateMonthsByPeriod(SummaryQuery $filter): array;
}
