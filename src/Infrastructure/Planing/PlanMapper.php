<?php
declare(strict_types=1);

namespace App\Infrastructure\Planing;

use App\Domain\Planing\Entity\Plan;
use App\Infrastructure\ORM\Doctrine\Entity\Plan as DoctrinePlan;
use App\Infrastructure\ORM\Doctrine\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

readonly class PlanMapper
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function toDomain(DoctrinePlan $entity): Plan
    {
        return new Plan(
            uuid: $entity->uuid,
            userUuid: $entity->user->uuid,
            name: $entity->name,
        );
    }

    public function toDoctrine(Plan $plan): DoctrinePlan
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->find($plan->userUuid);
        return new DoctrinePlan(
            uuid: $plan->uuid,
            user: $user,
            name: $plan->name,
        );
    }
}
