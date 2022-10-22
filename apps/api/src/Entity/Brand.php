<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'brand')]
class Brand
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    protected AbstractUid $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    /** @var Collection<int, Phone> */
    #[ORM\OneToMany(mappedBy: 'brand', targetEntity: Phone::class)]
    private Collection $phones;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->phones = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Brand
    {
        $this->name = $name;
        return $this;
    }

    /** @return Collection<int, Phone> */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    /**
     * @param Collection<int, Phone> $phones
     * @return Brand
     */
    public function setPhones(Collection $phones): Brand
    {
        $this->phones = $phones;
        return $this;
    }
}
