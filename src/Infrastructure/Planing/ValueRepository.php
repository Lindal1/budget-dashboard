<?php
declare(strict_types=1);

namespace App\Infrastructure\Planing;

use App\Domain\Planing\Dto\ValueQuery;
use App\Domain\Planing\Entity\Value;
use App\Domain\Planing\Repository\ValueRepositoryInterface;
use App\Infrastructure\ORM\Doctrine\Entity\PlanValue;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Polyfill\Intl\Icu\Exception\NotImplementedException;

readonly class ValueRepository implements ValueRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private ValueMapper            $valueMapper,
    )
    {
    }

    public function save(Value $value): void
    {
        throw new NotImplementedException('Method not implemented');
    }

    public function delete(Value $value): void
    {
        throw new NotImplementedException('Method not implemented');
    }

    public function search(ValueQuery $query): array
    {
        $qb = $this->em
            ->getRepository(PlanValue::class)
            ->createQueryBuilder('v');

        if ($query->planUuids) {
            $qb->andWhere('v.plan IN (:planUuids)')
                ->setParameter('planUuids', $query->planUuids);
        }

        if ($query->from) {
            $qb->andWhere('v.month >= :fromMonth')
                ->andWhere('v.year >= :fromYear')
                ->setParameter('fromMonth', $query->from->month)
                ->setParameter('fromYear', $query->from->year);
        }

        if ($query->to) {
            $qb->andWhere('v.month <= :toMonth')
                ->andWhere('v.year <= :toYear')
                ->setParameter('toMonth', $query->to->month)
                ->setParameter('toYear', $query->to->year);
        }

        return array_map(
            fn(PlanValue $value): Value => $this->valueMapper->toDomain($value),
            $qb->getQuery()->getResult()
        );
    }
}
