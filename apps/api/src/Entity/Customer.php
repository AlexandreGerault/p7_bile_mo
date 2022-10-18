<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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

    /**
     * @var Collection<int, CustomerUser>
     */
    #[ORM\OneToMany(mappedBy: 'client', targetEntity: CustomerUser::class)]
    private Collection $users;

    public function __construct(string $name, string $identifier, ?string $secret)
    {
        parent::__construct($name, $identifier, $secret);
        $this->users = new ArrayCollection();
    }

    /** @return Collection<int, CustomerUser> */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param Collection<int, CustomerUser> $users
     * @return Customer
     */
    public function setUsers(Collection $users): Customer
    {
        $this->users = $users;
        return $this;
    }
}
