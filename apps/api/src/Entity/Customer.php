<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use League\Bundle\OAuth2ServerBundle\Model\AbstractClient;

#[ORM\Entity]
#[ORM\Table(name: 'customer')]
class Customer extends AbstractClient
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 32)]
    protected $identifier;

    #[ORM\ManyToMany(targetEntity: CustomerUser::class, mappedBy: 'client')]
    private Collection $users;
}
