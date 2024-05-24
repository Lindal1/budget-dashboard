<?php
declare(strict_types=1);

namespace App\WebUI\Security\Voter;

use App\Domain\Category\Entity\Category;
use App\Domain\Planing\Entity\Plan;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class PlanVoter implements VoterInterface
{
    private const ATTRIBUTES = ['update', 'delete', 'view'];

    public function vote(TokenInterface $token, mixed $subject, array $attributes): int
    {
        if (!$subject instanceof Plan) {
            return self::ACCESS_ABSTAIN;
        }

        $attribute = $attributes[0] ?? null;
        if ((is_string($attribute) && !in_array($attribute, self::ATTRIBUTES))
            || (is_array($attribute) && array_intersect($attribute, self::ATTRIBUTES) === [])) {
            return self::ACCESS_ABSTAIN;
        }

        return $subject->userUuid->toString() === $token->getUser()->getUserIdentifier()
            ? self::ACCESS_GRANTED
            : self::ACCESS_DENIED;
    }
}
