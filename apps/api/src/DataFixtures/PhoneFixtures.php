<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Phone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PhoneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /** @var Brand $apple */
        $apple = $this->getReference(BrandFixtures::APPLE_BRAND_REFERENCE);
        $this->registerPhonesForBrand($apple, 'iPhone', 1000 * 100, $manager);

        /** @var Brand $samsung */
        $samsung = $this->getReference(BrandFixtures::SAMSUNG_BRAND_REFERENCE);
        $this->registerPhonesForBrand($samsung, 'Galaxy', 800 * 100, $manager);

        /** @var Brand $xiaomi */
        $xiaomi = $this->getReference(BrandFixtures::XIAOMI_BRAND_REFERENCE);
        $this->registerPhonesForBrand($xiaomi, 'Mi', 400 * 100, $manager);

        /** @var Brand $huawei */
        $huawei = $this->getReference(BrandFixtures::HUAWEI_BRAND_REFERENCE);
        $this->registerPhonesForBrand($huawei, 'P', 550 * 100, $manager);

        /** @var Brand $sony */
        $sony = $this->getReference(BrandFixtures::SONY_BRAND_REFERENCE);
        $this->registerPhonesForBrand($sony, 'Xperia', 450 * 100, $manager);

        /** @var Brand $lg */
        $lg = $this->getReference(BrandFixtures::LG_BRAND_REFERENCE);
        $this->registerPhonesForBrand($lg, 'G', 700 * 100, $manager);

        /** @var Brand $motorola */
        $motorola = $this->getReference(BrandFixtures::MOTOROLA_BRAND_REFERENCE);
        $this->registerPhonesForBrand($motorola, 'Moto', 650 * 100, $manager);

        $manager->flush();
    }

    private function registerPhonesForBrand(Brand $brand, string $model, int $basePrice, ObjectManager $manager): void
    {
        for ($i = 7; $i < 15; $i++) {
            $phone = new Phone();
            $phone->setModel($model . ' ' . $i);
            $phone->setDescription($model . ' ' . $i . ' description');
            $phone->setBrand($brand);
            $phone->setPrice($basePrice + $i * 10000);
            $manager->persist($phone);
        }
    }
}
