<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Phone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PhoneFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /** @var Brand $apple */
        $apple = $this->getReference(BrandFixtures::APPLE_BRAND_REFERENCE);
        for ($i = 7; $i < 15; $i++) {
            $phone = new Phone();
            $phone->setModel('iPhone ' . $i);
            $phone->setDescription('iPhone ' . $i . ' description');
            $phone->setBrand($apple);
            $phone->setPrice(100000 + $i * 10000);
            $manager->persist($phone);
        }

        /** @var Brand $samsung */
        $samsung = $this->getReference(BrandFixtures::SAMSUNG_BRAND_REFERENCE);
        for ($i = 1; $i < 15; $i++) {
            $phone = new Phone();
            $phone->setModel('Galaxy ' . $i);
            $phone->setDescription('Galaxy ' . $i . ' description');
            $phone->setBrand($samsung);
            $phone->setPrice(80000 + $i * 10000);
            $manager->persist($phone);
        }

        /** @var Brand $xiaomi */
        $xiaomi = $this->getReference(BrandFixtures::XIAOMI_BRAND_REFERENCE);
        for ($i = 1; $i < 15; $i++) {
            $phone = new Phone();
            $phone->setModel('Mi ' . $i);
            $phone->setDescription('Mi ' . $i . ' description');
            $phone->setBrand($xiaomi);
            $phone->setPrice(70000 + $i * 10000);
            $manager->persist($phone);
        }

        /** @var Brand $huawei */
        $huawei = $this->getReference(BrandFixtures::HUAWEI_BRAND_REFERENCE);
        for ($i = 1; $i < 15; $i++) {
            $phone = new Phone();
            $phone->setModel('P ' . $i);
            $phone->setDescription('P ' . $i . ' description');
            $phone->setBrand($huawei);
            $phone->setPrice(55000 + $i * 10000);
            $manager->persist($phone);
        }

        /** @var Brand $sony */
        $sony = $this->getReference(BrandFixtures::SONY_BRAND_REFERENCE);
        for ($i = 1; $i < 15; $i++) {
            $phone = new Phone();
            $phone->setModel('Xperia ' . $i);
            $phone->setDescription('Xperia ' . $i . ' description');
            $phone->setBrand($sony);
            $phone->setPrice(65000 + $i * 10000);
            $manager->persist($phone);
        }

        /** @var Brand $lg */
        $lg = $this->getReference(BrandFixtures::LG_BRAND_REFERENCE);
        for ($i = 1; $i < 15; $i++) {
            $phone = new Phone();
            $phone->setModel('G ' . $i);
            $phone->setDescription('G ' . $i . ' description');
            $phone->setBrand($lg);
            $phone->setPrice(75000 + $i * 10000);
            $manager->persist($phone);
        }

        /** @var Brand $motorola */
        $motorola = $this->getReference(BrandFixtures::MOTOROLA_BRAND_REFERENCE);
        for ($i = 1; $i < 15; $i++) {
            $phone = new Phone();
            $phone->setModel('Moto ' . $i);
            $phone->setDescription('Moto ' . $i . ' description');
            $phone->setBrand($motorola);
            $phone->setPrice(85000 + $i * 10000);
            $manager->persist($phone);
        }

        $manager->flush();
    }
}
