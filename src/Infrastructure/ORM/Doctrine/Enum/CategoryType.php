<?php
declare(strict_types=1);

namespace App\Infrastructure\ORM\Doctrine\Enum;

enum CategoryType: string
{
    case Income = 'income';
    case Expense = 'expense';
}
