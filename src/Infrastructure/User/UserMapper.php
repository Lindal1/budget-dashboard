<?php
declare(strict_types=1);

namespace App\Infrastructure\User;

use App\Domain\User\Entity\User;
use App\Domain\User\Enum\UserStatus;
use App\Infrastructure\ORM\Doctrine\Entity\User as DoctrineUser;
use App\Infrastructure\ORM\Doctrine\Enum\UserStatus as DoctrineUserStatus;

class UserMapper
{
    public function toDoctrine(User $user): DoctrineUser
    {
        return new DoctrineUser(
            $user->uuid,
            $user->email,
            $this->toDoctrineStatus($user->status)
        );
    }

    public function toDomain(DoctrineUser $user): User
    {
        return new User(
            $user->uuid,
            $user->email,
            $this->toDomainStatus($user->status)
        );
    }

    public function toDoctrineStatus(UserStatus $status): DoctrineUserStatus
    {
        return match ($status) {
            UserStatus::Active => DoctrineUserStatus::Active,
            UserStatus::Inactive => DoctrineUserStatus::Inactive,
            UserStatus::Deleted => DoctrineUserStatus::Deleted,
        };
    }

    public function toDomainStatus(DoctrineUserStatus $status): UserStatus
    {
        return match ($status) {
            DoctrineUserStatus::Active => UserStatus::Active,
            DoctrineUserStatus::Inactive => UserStatus::Inactive,
            DoctrineUserStatus::Deleted => UserStatus::Deleted,
        };
    }
}
