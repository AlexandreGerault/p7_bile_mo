<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public const APPLE_BRAND_REFERENCE = 'apple';
    public const SAMSUNG_BRAND_REFERENCE = 'samsung';
    public const XIAOMI_BRAND_REFERENCE = 'xiaomi';
    public const HUAWEI_BRAND_REFERENCE = 'huawei';
    public const SONY_BRAND_REFERENCE = 'sony';
    public const LG_BRAND_REFERENCE = 'lg';
    public const MOTOROLA_BRAND_REFERENCE = 'motorola';

    public function load(ObjectManager $manager)
    {
        $appleBrand = new Brand();
        $appleBrand->setName('Apple');
        $manager->persist($appleBrand);
        $this->addReference(self::APPLE_BRAND_REFERENCE, $appleBrand);

        $samsungBrand = new Brand();
        $samsungBrand->setName('Samsung');
        $manager->persist($samsungBrand);
        $this->addReference(self::SAMSUNG_BRAND_REFERENCE, $samsungBrand);

        $xiaomiBrand = new Brand();
        $xiaomiBrand->setName('Xiaomi');
        $manager->persist($xiaomiBrand);
        $this->addReference(self::XIAOMI_BRAND_REFERENCE, $xiaomiBrand);

        $huaweiBrand = new Brand();
        $huaweiBrand->setName('Huawei');
        $manager->persist($huaweiBrand);
        $this->addReference(self::HUAWEI_BRAND_REFERENCE, $huaweiBrand);

        $sonyBrand = new Brand();
        $sonyBrand->setName('Sony');
        $manager->persist($sonyBrand);
        $this->addReference(self::SONY_BRAND_REFERENCE, $sonyBrand);

        $lgBrand = new Brand();
        $lgBrand->setName('LG');
        $manager->persist($lgBrand);
        $this->addReference(self::LG_BRAND_REFERENCE, $lgBrand);

        $motorolaBrand = new Brand();
        $motorolaBrand->setName('Motorola');
        $manager->persist($motorolaBrand);
        $this->addReference(self::MOTOROLA_BRAND_REFERENCE, $motorolaBrand);

        $manager->flush();
    }
}
