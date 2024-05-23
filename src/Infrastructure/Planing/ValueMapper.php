<?php
declare(strict_types=1);

namespace App\Infrastructure\Planing;

use App\Domain\Planing\Entity\Value;
use App\Domain\Planing\ValueObject\Month;
use App\Infrastructure\Category\CategoryMapping;
use App\Infrastructure\ORM\Doctrine\Entity\PlanValue;

readonly class ValueMapper
{
    public function __construct(
        private CategoryMapping $categoryMapping,
        private PlanMapper      $planMapper,
    )
    {
    }

    public function toDomain(PlanValue $planValue): Value
    {
        return new Value(
            $this->planMapper->toDomain($planValue->plan),
            new Month($planValue->month, $planValue->year),
            $this->categoryMapping->toDomain($planValue->category),
            $planValue->value,
        );
    }

    public function toDoctrine(Value $value): PlanValue
    {
        return new PlanValue(
            plan: $this->planMapper->toDoctrine($value->plan),
            category: $this->categoryMapping->toDoctrine($value->category),
            month: $value->month->month,
            year: $value->month->year,
            value: $value->value,
        );
    }
}
