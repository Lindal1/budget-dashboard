<?php
declare(strict_types=1);

namespace App\Domain\Category\Enum;

enum CategoryType
{
    case Income;
    case Expense;

    public function getValue(): string
    {
        return match ($this) {
            self::Income => 'Income',
            self::Expense => 'Expense',
        };
    }
}
