<?php
declare(strict_types=1);

namespace App\Domain\User\Event;

use App\Domain\User\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserEvent extends Event
{
    public const CREATED = 'user.created';
    public const UPDATED = 'user.updated';
    public const DELETED = 'user.deleted';

    public function __construct(
        public User $user,
    )
    {
    }
}
