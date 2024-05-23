<?php
declare(strict_types=1);

namespace App\Domain\Planing\ValueObject;

class Period
{
    public function __construct(
        public Month $start,
        public Month $end
    )
    {
    }
}
