<?php
declare(strict_types=1);

namespace App\Infrastructure\ORM\Doctrine\Entity;

use App\Infrastructure\ORM\Doctrine\Enum\CategoryType;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[
    ORM\Entity,
    ORM\Table(name: 'category')
]
class Category
{
    public function __construct(
        #[
            ORM\Id,
            ORM\Column(type: 'uuid'),
        ]
        public UuidInterface  $uuid,
        #[
            ORM\ManyToOne(targetEntity: 'User'),
            ORM\JoinColumn(name: 'user', referencedColumnName: 'uuid'),
        ]
        public User           $user,
        #[ORM\Column(type: 'string', enumType: CategoryType::class)]
        public CategoryType   $type,
        #[ORM\Column(type: 'string')]
        public string         $name,
        #[
            ORM\ManyToOne(targetEntity: 'CategoryGroup'),
            ORM\JoinColumn(name: 'group', referencedColumnName: 'uuid'),
        ]
        public ?CategoryGroup $group = null,
    )
    {
    }
}
