<?php
declare(strict_types=1);

namespace App\WebUI\Service\Planing;

use App\Domain\Category\Dto\CategoryQuery;
use App\Domain\Category\Enum\CategoryType;
use App\Domain\Category\Repository\CategoryRepositoryInterface;
use App\Domain\Planing\Dto\ValueQuery;
use App\Domain\Planing\Entity\Plan;
use App\Domain\Planing\Repository\ValueRepositoryInterface;
use App\Domain\Planing\ValueObject\Period;
use App\WebUI\Dto\Planing\PlanTable;

readonly class PlanService
{
    public function __construct(
        private ValueRepositoryInterface    $valueRepository,
        private CategoryRepositoryInterface $categoryRepository,
    )
    {
    }

    public function getTable(Plan $plan, Period $period): PlanTable
    {
        $table = new PlanTable(
            $period
        );

        $table->setCategories(
            $this->categoryRepository->search(new CategoryQuery(userUuids: [$plan->userUuid]))
        );

        $values = $this->valueRepository->search(
            new ValueQuery(
                planUuids: [$plan->uuid],
                from: $period->start,
                to: $period->end
            )
        );

        foreach ($values as $value) {
            match ($value->category->type) {
                CategoryType::Expense => $table->addExpense($value->category, $value->month, $value->value),
                CategoryType::Income => $table->addIncome($value->category, $value->month, $value->value),
            };
        }

        return $table;
    }
}
