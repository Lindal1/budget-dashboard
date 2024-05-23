<?php
declare(strict_types=1);

namespace App\WebUI\Entity;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(
        private UuidInterface $uuid,
        private string        $password,
    )
    {
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
        return;
    }

    public function getUserIdentifier(): string
    {
        return $this->uuid->toString();
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
