<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\CustomerUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use League\Bundle\OAuth2ServerBundle\Manager\ClientManagerInterface;

class AppFixtures extends Fixture
{
    public function __construct(private ClientManagerInterface $clientManager)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createCustomer('Test', 'test', 'test');

        $manager->flush();
    }

    private function createCustomer(string $name, string $identifier, string $secret): void
    {
        $client = new Customer($name, $identifier, $identifier);
        $client->setActive(true);
        $client->setAllowPlainTextPkce(true);

        $this->clientManager->save($client);
    }
}
