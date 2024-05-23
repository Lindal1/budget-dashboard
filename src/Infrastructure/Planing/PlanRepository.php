<?php
declare(strict_types=1);

namespace App\Infrastructure\Planing;

use App\Domain\Planing\Entity\Plan;
use App\Domain\Planing\Repository\PlanRepositoryInterface;
use App\Infrastructure\ORM\Doctrine\Entity\Plan as DoctrinePlan;
use App\Infrastructure\ORM\Doctrine\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

readonly class PlanRepository implements PlanRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PlanMapper             $planMapper,
    )
    {
    }

    public function save(Plan $plan): void
    {
        $entity = $this->entityManager->getRepository(DoctrinePlan::class)->find($plan->uuid);
        if (!$entity) {
            $entity = $this->planMapper->toDoctrine($plan);
        } else {
            $entity->name = $plan->name;
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function delete(Plan $plan): void
    {
        $entity = $this->entityManager
            ->getRepository(DoctrinePlan::class)
            ->find($plan->uuid);

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    public function getByUuid(UuidInterface $uuid): ?Plan
    {
        $entity = $this->entityManager
            ->getRepository(DoctrinePlan::class)
            ->find($uuid);

        if ($entity === null) {
            return null;
        }

        return $this->planMapper->toDomain($entity);
    }

    public function getByUserUuid(UuidInterface $userUuid): array
    {
        $entities = $this->entityManager
            ->getRepository(DoctrinePlan::class)
            ->findBy(['user' => $userUuid]);

        return array_map(
            fn(DoctrinePlan $entity) => $this->planMapper->toDomain($entity),
            $entities
        );
    }
}
