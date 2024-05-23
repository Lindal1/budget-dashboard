<?php
declare(strict_types=1);

namespace App\WebUI\Security;

use App\Domain\Auth\Repository\LoginRepositoryInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\WebUI\Entity\User;
use Ramsey\Uuid\Nonstandard\Uuid;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

readonly class UserProvider implements UserProviderInterface
{
    public function __construct(
        private UserRepositoryInterface  $userRepository,
        private LoginRepositoryInterface $loginRepository,
    )
    {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->userRepository->get(Uuid::fromString($identifier));
        if (!$user) {
            throw new UserNotFoundException();
        }

        $login = $this->loginRepository->findByUuid($user->uuid);
        if (!$login) {
            throw new UserNotFoundException();
        }

        return new User($user->uuid, $login->passwordHash);
    }
}
