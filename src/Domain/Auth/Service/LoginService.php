<?php
declare(strict_types=1);

namespace App\Domain\Auth\Service;

use App\Domain\Auth\Entity\LoginAuth;
use App\Domain\Auth\Repository\LoginRepositoryInterface;
use App\Shared\Exception\ValidationException;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LoginService implements LoginAuthServiceInterface
{
    public function __construct(
        private readonly LoginRepositoryInterface $loginRepository,
        private readonly PasswordEncoderInterface $passwordEncoder,
        private readonly ValidatorInterface       $validator,
    )
    {
    }

    public function set(UuidInterface $uuid, string $login, string $password): void
    {
        $passwordHash = $this->passwordEncoder->encode($password);
        $login = new LoginAuth($uuid, $login, $passwordHash);
        $errors = $this->validator->validate($login);
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        $this->loginRepository->save($login);
    }

    public function find(string $login, string $password): ?UuidInterface
    {
        $loginAuth = $this->loginRepository->findByLogin($login);
        if ($loginAuth === null) {
            return null;
        }

        if (!$this->passwordEncoder->verify($password, $loginAuth->passwordHash)) {
            return null;
        }

        return $loginAuth->uuid;
    }
}
