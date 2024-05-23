<?php
declare(strict_types=1);

namespace App\WebUI\ArgumentResolver;

use App\Domain\Planing\Entity\Plan;
use App\Domain\Planing\Repository\PlanRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class PlanValueResolver implements ValueResolverInterface
{
    public function __construct(
        private PlanRepositoryInterface $planRepository,
    )
    {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() !== Plan::class || !$request->attributes->has('uuid')) {
            return [];
        }

        $plan = $this->planRepository->getByUuid(Uuid::fromString($request->attributes->get('uuid')));
        if ($plan === null) {
            throw new NotFoundHttpException('Plan not found');
        }

        yield $plan;
    }
}
