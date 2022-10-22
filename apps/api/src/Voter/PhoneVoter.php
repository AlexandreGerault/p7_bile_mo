<?php

declare(strict_types=1);

namespace App\Voter;

use App\Entity\Phone;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PhoneVoter extends Voter
{
    const VIEW = 'view';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if ($attribute != self::VIEW) {
            return false;
        }

        if (!$subject instanceof Phone) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        return true;
    }
}
