<?php
declare(strict_types=1);

namespace App\Domain\User\Dto;

use App\Domain\User\Enum\UserStatus;

class UserQuery
{
    public function __construct(
        public array $uuids = [],
        public array $emails = [],
        /** @var UserStatus[] */
        public array $statuses = [],
    )
    {
    }
}
