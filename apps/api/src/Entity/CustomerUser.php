<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use League\Bundle\OAuth2ServerBundle\Entity\Client;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'customer_user')]
#[UniqueEntity(fields: ['email'])]
class CustomerUser
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['customer_user:read'])]
    private AbstractUid $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['customer_user:read'])]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Groups(['customer_user:read'])]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Groups(['customer_user:read'])]
    private string $lastName;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'users')]
    #[ORM\JoinColumn(name: 'customer_id', referencedColumnName: 'identifier', nullable: false)]
    private Customer $client;

    public function __construct()
    {
        $this->id = Uuid::v4();
    }

    public function getId(): AbstractUid
    {
        return $this->id;
    }

    public function setId(AbstractUid $id): CustomerUser
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): CustomerUser
    {
        $this->email = $email;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): CustomerUser
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): CustomerUser
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setClient(Customer $client): CustomerUser
    {
        $this->client = $client;
        return $this;
    }

    public function getClient(): Customer
    {
        return $this->client;
    }
}
