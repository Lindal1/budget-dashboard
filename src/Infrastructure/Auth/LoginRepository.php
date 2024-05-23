<?php

namespace App\Infrastructure\Auth;

use App\Domain\Auth\Entity\LoginAuth;
use App\Domain\Auth\Repository\LoginRepositoryInterface;
use App\Infrastructure\ORM\Doctrine\Entity\Auth;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class LoginRepository implements LoginRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function save(LoginAuth $loginAuth): void
    {
        $entity = $this->entityManager->getRepository(Auth::class)->find($loginAuth->uuid);
        if (!$entity) {
            $entity = new Auth(
                $loginAuth->uuid,
                $loginAuth->login,
                $loginAuth->passwordHash,
            );
        } else {
            $entity->login = $loginAuth->login;
            $entity->passwordHash = $loginAuth->passwordHash;
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function findByLogin(string $login): ?LoginAuth
    {
        $entity = $this->entityManager->getRepository(Auth::class)->findOneBy(['login' => $login]);
        if (!$entity) {
            return null;
        }

        return new LoginAuth(
            $entity->uuid,
            $entity->login,
            $entity->passwordHash,
        );
    }

    public function findByUuid(UuidInterface $uuid): ?LoginAuth
    {
        $entity = $this->entityManager->getRepository(Auth::class)->find($uuid);
        if (!$entity) {
            return null;
        }

        return new LoginAuth(
            $entity->uuid,
            $entity->login,
            $entity->passwordHash,
        );
    }
}
