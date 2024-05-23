<?php
declare(strict_types=1);

namespace App\Domain\Planing\Dto;

use App\Domain\Planing\ValueObject\Month;

class ValueQuery
{
    public function __construct(
        public array  $planUuids = [],
        public array  $categoryUuids = [],
        public ?Month $from = null,
        public ?Month $to = null,
    )
    {
    }
}
