<?php
declare(strict_types=1);

namespace App\WebUI\Dto\Planing;

use App\Domain\Category\Entity\Category;
use App\Domain\Category\Enum\CategoryType;
use App\Domain\Planing\ValueObject\Month;
use App\Domain\Planing\ValueObject\Period;

class PlanTable
{
    private array $incomes = [];
    private array $expenses = [];

    private array $incomeCategories = [];
    private array $expenseCategories = [];

    public function __construct(
        public Period $period,
    )
    {
    }

    public function addIncome(Category $category, Month $month, int $value): void
    {
        $this->incomes[$category->uuid->toString()][$month->year . '-' . $month->month] = $value;
    }

    public function addExpense(Category $category, Month $month, int $value): void
    {
        $this->expenses[$category->uuid->toString()][$month->year . '-' . $month->month] = $value;
    }

    public function getIncomeFor(Category $category, Month $month): float
    {
        return round(($this->incomes[$category->uuid->toString()][$month->year . '-' . $month->month] ?? 0) / 100, 2);
    }

    public function getExpenseFor(Category $category, Month $month): float
    {
        return round(($this->expenses[$category->uuid->toString()][$month->month . '-' . $month->year] ?? 0) / 100, 2);
    }

    /**
     * @return Month[]
     * @throws \Exception
     */
    public function getMonths(): array
    {
        $startDateTime = new \DateTime($this->period->start->year . '-' . $this->period->start->month . '-01');
        $endDateTime = new \DateTime($this->period->end->year . '-' . $this->period->end->month . '-01');
        $endDateTime->modify('+1 month');

        $interval = new \DateInterval('P1M');
        $period = new \DatePeriod($startDateTime, $interval, $endDateTime);

        $months = [];
        foreach ($period as $date) {
            $months[] = new Month((int)$date->format('m'), (int)$date->format('Y'));
        }

        return $months;
    }

    public function getIncomeCategories(): array
    {
        return $this->incomeCategories;
    }

    public function getExpenseCategories(): array
    {
        return $this->expenseCategories;
    }

    /**
     * @param Category[] $categories
     */
    public function setCategories(array $categories): void
    {
        foreach ($categories as $category) {
            match ($category->type) {
                CategoryType::Income => $this->incomeCategories[$category->uuid->toString()] = $category,
                CategoryType::Expense => $this->expenseCategories[$category->uuid->toString()] = $category,
            };
        }
    }
}
