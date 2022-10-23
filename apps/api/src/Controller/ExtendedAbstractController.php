<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Customer;
use League\Bundle\OAuth2ServerBundle\Manager\ClientManagerInterface;
use League\Bundle\OAuth2ServerBundle\Model\AbstractClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ExtendedAbstractController extends AbstractController
{
    public static function getSubscribedServices(): array
    {
        $default = parent::getSubscribedServices();

        return $default + [
                'league.oauth2_server.manager.doctrine.client ' => '?' . ClientManagerInterface::class,
            ];
    }

    public function getOAuthClient(): AbstractClient
    {
        /** @var ClientManagerInterface $clientManager */
        $clientManager = $this->container->get('league.oauth2_server.manager.doctrine.client ');
        /** @var TokenStorageInterface $security */
        $security = $this->container->get('security.token_storage');

        /** @var string $oauthClientId */
        $oauthClientId = $security->getToken()?->getAttribute('oauth_client_id');

        $customer = $clientManager->find($oauthClientId);

        if (is_null($customer)) {
            throw new \Exception('Customer not found');
        }

        return $customer;
    }

    protected function jsonParams(Request $request): string
    {
        $payload = $request->getContent();

        if ($payload === "") {
            $payload = json_encode($request->request->all());
        }

        if (!is_string($payload)) {
            throw new \Exception('Invalid payload');
        }

        return $payload;
    }
}
