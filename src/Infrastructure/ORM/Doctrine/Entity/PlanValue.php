<?php
declare(strict_types=1);

namespace App\Infrastructure\ORM\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity,
    ORM\Table(name: 'plan_value'),
]
class PlanValue
{
    public function __construct(
        #[
            ORM\Id,
            ORM\JoinColumn(name: 'plan', referencedColumnName: 'uuid'),
            ORM\ManyToOne(targetEntity: Plan::class),
        ]
        public Plan     $plan,
        #[
            ORM\Id,
            ORM\JoinColumn(name: 'category', referencedColumnName: 'uuid'),
            ORM\ManyToOne(targetEntity: Category::class),
        ]
        public Category $category,
        #[
            ORM\Id,
            ORM\Column(type: 'integer'),
        ]
        public int      $month,
        #[
            ORM\Id,
            ORM\Column(type: 'integer'),
        ]
        public int      $year,
        #[ORM\Column(type: 'integer')]
        public int    $value,
    )
    {
    }
}
