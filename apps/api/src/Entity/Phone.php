<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'phone')]
class Phone
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[Groups(['phone:read'])]
    private AbstractUid $id;

    #[ORM\ManyToOne(targetEntity: Brand::class)]
    private Brand $brand;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['phone:read'])]
    private string $model;

    #[ORM\Column(type: 'integer')]
    #[Groups(['phone:read'])]
    private int $price;

    #[ORM\Column(type: 'string')]
    #[Groups(['phone:read'])]
    private string $description;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['phone:read'])]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): AbstractUid
    {
        return $this->id;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function setBrand(Brand $brand): Phone
    {
        $this->brand = $brand;
        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): Phone
    {
        $this->model = $model;
        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): Phone
    {
        $this->price = $price;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Phone
    {
        $this->description = $description;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): Phone
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
