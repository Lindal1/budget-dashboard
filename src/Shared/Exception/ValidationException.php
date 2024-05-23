<?php
declare(strict_types=1);

namespace App\Shared\Exception;

use Symfony\Component\Validator\ConstraintViolationList;

class ValidationException extends RuntimeException
{
    public function __construct(public ConstraintViolationList $errors)
    {
        parent::__construct('validation error', 0, null);
    }
}
