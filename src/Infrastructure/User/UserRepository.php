<?php
declare(strict_types=1);

namespace App\Infrastructure\User;

use App\Domain\User\Dto\UserQuery;
use App\Domain\User\Entity\User;
use App\Domain\User\Enum\UserStatus;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\ORM\Doctrine\Entity\User as DoctrineUser;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserMapper             $userMapper,
    )
    {
    }

    public function save(User $user): void
    {
        $this->entityManager->persist(
            $this->userMapper->toDoctrine($user)
        );

        $this->entityManager->flush();
    }

    public function delete(User $user): void
    {
        $this->entityManager->remove(
            $this->userMapper->toDoctrine($user)
        );

        $this->entityManager->flush();
    }

    public function search(UserQuery $query): array
    {
        $qb = $this->entityManager
            ->getRepository(DoctrineUser::class)
            ->createQueryBuilder('u')
            ->select('u');

        if (!empty($query->uuids)) {
            $qb->andWhere('u.uuid IN (:uuids)')
                ->setParameter('uuids', $query->uuids);
        }

        if (!empty($query->emails)) {
            $qb->andWhere('u.email IN (:emails)')
                ->setParameter('emails', $query->emails);
        }

        if (!empty($query->statuses)) {
            $qb->andWhere('u.status IN (:statuses)')
                ->setParameter(
                    'statuses',
                    array_map(
                        fn(UserStatus $status) => $this->userMapper->toDoctrineStatus($status),
                        $query->statuses
                    )
                );
        }

        return array_map(
            fn(DoctrineUser $user) => $this->userMapper->toDomain($user),
            $qb->getQuery()->getResult()
        );
    }

    public function get(UuidInterface $uuid): ?User
    {
        $user = $this->entityManager
            ->getRepository(DoctrineUser::class)
            ->find($uuid);

        return $user ? $this->userMapper->toDomain($user) : null;
    }

    public function getByEmail(string $email): ?User
    {
        $user = $this->entityManager
            ->getRepository(DoctrineUser::class)
            ->findOneBy(['email' => $email]);

        return $user ? $this->userMapper->toDomain($user) : null;
    }
}
