<?php
declare(strict_types=1);

namespace App\WebUI\Validator;

use Symfony\Component\Validator\Constraint;

class UserExist extends Constraint
{
    public string $message = 'Invalid email or password.';
}
