<?php
declare(strict_types=1);

namespace App\Domain\Auth\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniqueLogin extends Constraint
{
    public string $message = 'The login "{{ value }}" is already in use.';
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
