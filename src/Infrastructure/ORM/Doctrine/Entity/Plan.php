<?php
declare(strict_types=1);

namespace App\Infrastructure\ORM\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[
    ORM\Entity,
    ORM\Table(name: 'plan')
]
class Plan
{
    public function __construct(
        #[
            ORM\Id,
            ORM\Column(type: 'uuid'),
        ]
        public readonly UuidInterface $uuid,
        #[
            ORM\ManyToOne(targetEntity: 'User'),
            ORM\JoinColumn(name: 'user', referencedColumnName: 'uuid'),
        ]
        public User                   $user,
        #[ORM\Column(type: 'string')]
        public string                 $name,
    )
    {
    }
}
