<?php
declare(strict_types=1);

namespace App\Infrastructure\ORM\Doctrine\Entity;

use App\Infrastructure\ORM\Doctrine\Enum\UserStatus;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[
    ORM\Entity,
    ORM\Table(name: 'user')
]
class User
{
    public function __construct(
        #[ORM\Id, ORM\Column(type: 'uuid')]
        public UuidInterface       $uuid,
        #[ORM\Column(type: 'string')]
        public string              $email,
        #[ORM\Column(type: 'string', enumType: UserStatus::class)]
        public UserStatus          $status,
    )
    {
    }
}
