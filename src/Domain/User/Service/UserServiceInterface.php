<?php

namespace App\Domain\User\Service;

use App\Domain\User\Entity\User;

interface UserServiceInterface
{
    public function create(User $user): void;

    public function update(User $user): void;

    public function delete(User $user): void;
}
