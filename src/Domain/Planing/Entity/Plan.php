<?php
declare(strict_types=1);

namespace App\Domain\Planing\Entity;

use Ramsey\Uuid\UuidInterface;

class Plan
{
    public function __construct(
        public readonly UuidInterface $uuid,
        public readonly UuidInterface $userUuid,
        public string                 $name,
    )
    {
    }
}
