<?php

declare(strict_types=1);

namespace App\Voter;

use App\Entity\CustomerUser;
use League\Bundle\OAuth2ServerBundle\Manager\ClientManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CustomerUserVoter extends Voter
{
    const VIEW = 'view';

    public function __construct(private readonly ClientManagerInterface $clientManager)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::VIEW])) {
            return false;
        }

        if (!$subject instanceof CustomerUser) {
            return false;
        }

        return true;
    }

    /**
     * @param CustomerUser $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $customer = $this->clientManager->find($token->getAttribute('oauth_client_id'));

        if (is_null($customer)) {
            return false;
        }

        if ($customer->getIdentifier() !== $subject->getClient()->getIdentifier()) {
            return false;
        }

        return true;
    }
}
