<?php
declare(strict_types=1);

namespace App\Infrastructure\ORM\Doctrine\Entity;

use App\Infrastructure\ORM\Doctrine\Enum\CategoryType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[
    ORM\Entity,
    ORM\Table(name: 'category_group')
]
class CategoryGroup
{

    #[
        ORM\OneToMany(mappedBy: 'group', targetEntity: Category::class),
    ]
    public Collection $categories;

    public function __construct(
        #[
            ORM\Id,
            ORM\Column(type: 'uuid'),
        ]
        public UuidInterface $uuid,
        #[ORM\Column(type: 'string', enumType: CategoryType::class)]
        public CategoryType  $type,
        #[
            ORM\ManyToOne(targetEntity: User::class),
            ORM\JoinColumn(name: 'user', referencedColumnName: 'uuid'),
        ]
        public User          $user,
        #[ORM\Column(type: 'string')]
        public string        $name,
    )
    {
        $this->categories = new ArrayCollection();
    }
}
