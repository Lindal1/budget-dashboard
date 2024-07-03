<?php
declare(strict_types=1);

namespace App\WebUI\Dto\Planing;

use App\Domain\Category\Entity\Category;
use App\Domain\Category\Enum\CategoryType;
use App\Domain\Planing\Entity\Value;
use App\Domain\Planing\ValueObject\Month;
use App\Domain\Planing\ValueObject\Period;
use http\Encoding\Stream\Deflate;

class PlanTable
{
    public function __construct(
        public Period $period,
        private array $categories = [],
        private array $values = [],
    )
    {
    }

    public function getValueFor(Category $category, Month $month): float
    {
        return $this->values[$category->uuid->toString()][$this->getMonthKey($month)] ?? 0;
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
        return array_reduce($this->categories, function ($carry, Category $category) {
            if ($category->type === CategoryType::Income) {
                $carry[] = $category;
            }

            return $carry;
        }, []);
    }

    public function getExpenseCategories(): array
    {
        return array_reduce($this->categories, function ($carry, Category $category) {
            if ($category->type === CategoryType::Expense) {
                $carry[] = $category;
            }

            return $carry;
        }, []);
    }

    public function getSumExpenseByMonth(Month $month): float
    {
        $categories = $this->getExpenseCategories();
        $result = 0;
        foreach ($categories as $category) {
            $result += $this->getValueFor($category, $month);
        }

        return $result;
    }

    public function getSumIncomeByMonth(Month $month): float
    {
        $categories = $this->getIncomeCategories();
        $result = 0;
        foreach ($categories as $category) {
            $result += $this->getValueFor($category, $month);
        }

        return $result;

    }

    public function getSumByCategory(Category $category): float
    {
        $months = $this->getMonths();
        $result = 0;
        foreach ($months as $month) {
            $result += $this->getValueFor($category, $month);
        }

        return $result;
    }

    public function getAvgByCategory(Category $category): float
    {
        $months = $this->getMonths();
        $result = 0;
        foreach ($months as $month) {
            $result += $this->getValueFor($category, $month);
        }

        return $result / count($months);
    }

    /**
     * @param Value[] $values
     * @return void
     */
    public function setValues(array $values): void
    {
        foreach ($values as $value) {
            $this->values[$value->category->uuid->toString()][$this->getMonthKey($value->month)] = round($value->value / 100, 2);
        }
    }

    private function getMonthKey(Month $month): string
    {
        return $month->year . '-' . $month->month;
    }
}
