<?php

namespace App\Domain\Auth\Service;

class PasswordEncoder implements PasswordEncoderInterface
{
    public function encode(string $password): string
    {
        return hash('sha256', $password);
    }

    public function verify(string $password, string $hash): bool
    {
        return hash('sha256', $password) === $hash;
    }
}
