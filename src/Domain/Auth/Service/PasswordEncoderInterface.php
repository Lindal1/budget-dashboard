<?php

namespace App\Domain\Auth\Service;

interface PasswordEncoderInterface
{
    public function encode(string $password): string;

    public function verify(string $password, string $hash): bool;
}