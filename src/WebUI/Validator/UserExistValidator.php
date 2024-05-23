<?php
declare(strict_types=1);

namespace App\WebUI\Validator;

use App\Domain\Auth\Service\LoginAuthServiceInterface;
use App\WebUI\Form\Auth\Login;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UserExistValidator extends ConstraintValidator
{
    public function __construct(
        private readonly LoginAuthServiceInterface $loginAuthService,
    ){}
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UserExist) {
            throw new UnexpectedTypeException($constraint, UserExist::class);
        }

        if (!$value instanceof Login) {
            throw new UnexpectedTypeException($value, Login::class);
        }

        $uuid = $this->loginAuthService->find($value->email, $value->password);
        if (!$uuid) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
