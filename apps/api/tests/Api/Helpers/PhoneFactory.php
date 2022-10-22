<?php

declare(strict_types=1);

namespace App\Tests\Api\Helpers;

use App\Entity\Brand;
use App\Entity\Phone;

trait PhoneFactory
{
    public function createPhone(array $data = []): Phone
    {
        $brand = $this->createBrand($data['brand'] ?? "Apple");

        $phone = new Phone();
        $phone->setBrand($brand);
        $phone->setModel($data['model'] ?? 'iPhone 12');
        $phone->setPrice($data['price'] ?? 99999);
        $phone->setDescription($data['description'] ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $phone->setCreatedAt($data['createdAt'] ?? new \DateTimeImmutable());

        $this->getEntityManagerInterface()->persist($brand);
        $this->getEntityManagerInterface()->persist($phone);
        $this->getEntityManagerInterface()->flush();

        return $phone;
    }

    private function createBrand(string $name): Brand
    {
        $brand = new Brand();
        $brand->setName($name);

        return $brand;
    }
}
