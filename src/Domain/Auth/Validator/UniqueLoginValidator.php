<?php
declare(strict_types=1);

namespace App\Domain\Auth\Validator;

use App\Domain\Auth\Entity\LoginAuth;
use App\Domain\Auth\Repository\LoginRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

#[\Attribute]
class UniqueLoginValidator extends ConstraintValidator
{
    public function __construct(
        private readonly LoginRepositoryInterface $repository,
    )
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof LoginAuth) {
            return;
        }
        if (!$constraint instanceof UniqueLogin) {
            throw new \InvalidArgumentException('Unexpected constraint');
        }

        $entity = $this->repository->findByLogin($value->login);
        if (!$entity) {
            return;
        }
        if ($entity->uuid !== $value->uuid) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value->login)
                ->addViolation();
        }
    }
}
