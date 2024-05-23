<?php
declare(strict_types=1);

namespace App\Infrastructure\ORM\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[
    ORM\Entity,
    ORM\Table(name: 'auth')
]
class Auth
{
    public function __construct(
        #[
            ORM\Id,
            ORM\Column(name: 'uuid', type: 'uuid', unique: true, nullable: false)
        ]
        public UuidInterface $uuid,
        #[
            ORM\Column(name: 'login', type: 'string', length: 255, unique: true, nullable: false)
        ]
        public string $login,
        #[
            ORM\Column(name: 'password_hash', type: 'string', length: 255, nullable: false)
        ]
        public string $passwordHash,
    )
    {
    }
}
