<?php
declare(strict_types=1);

namespace App\Domain\User\Service;

use App\Domain\Shared\Exception\ValidationException;
use App\Domain\User\Entity\User;
use App\Domain\User\Event\UserEvent;
use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface  $userRepository,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly ValidatorInterface       $validator,
    )
    {
    }

    public function create(User $user): void
    {
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        $this->userRepository->save($user);
        $this->eventDispatcher->dispatch(new UserEvent($user), UserEvent::CREATED);
    }

    public function update(User $user): void
    {
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        $this->userRepository->save($user);
        $this->eventDispatcher->dispatch(new UserEvent($user), UserEvent::UPDATED);
    }

    public function delete(User $user): void
    {
        $this->userRepository->delete($user);
        $this->eventDispatcher->dispatch(new UserEvent($user), UserEvent::DELETED);
    }
}
