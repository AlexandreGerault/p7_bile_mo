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

    public function load(ObjectManager $manager): void
    {
        $this->registerApple($manager);

        $this->registerSamsung($manager);

        $this->registerXiaomi($manager);

        $this->registerHuawei($manager);

        $this->registerSony($manager);

        $this->registerLg($manager);

        $this->registerMotorola($manager);

        $manager->flush();
    }

    private function registerApple(ObjectManager $manager): void
    {
        $appleBrand = new Brand();
        $appleBrand->setName('Apple');
        $manager->persist($appleBrand);
        $this->addReference(self::APPLE_BRAND_REFERENCE, $appleBrand);
    }

    private function registerSamsung(ObjectManager $manager): void
    {
        $samsungBrand = new Brand();
        $samsungBrand->setName('Samsung');
        $manager->persist($samsungBrand);
        $this->addReference(self::SAMSUNG_BRAND_REFERENCE, $samsungBrand);
    }

    private function registerXiaomi(ObjectManager $manager): void
    {
        $xiaomiBrand = new Brand();
        $xiaomiBrand->setName('Xiaomi');
        $manager->persist($xiaomiBrand);
        $this->addReference(self::XIAOMI_BRAND_REFERENCE, $xiaomiBrand);
    }

    private function registerHuawei(ObjectManager $manager): void
    {
        $huaweiBrand = new Brand();
        $huaweiBrand->setName('Huawei');
        $manager->persist($huaweiBrand);
        $this->addReference(self::HUAWEI_BRAND_REFERENCE, $huaweiBrand);
    }

    private function registerSony(ObjectManager $manager): void
    {
        $sonyBrand = new Brand();
        $sonyBrand->setName('Sony');
        $manager->persist($sonyBrand);
        $this->addReference(self::SONY_BRAND_REFERENCE, $sonyBrand);
    }

    private function registerLg(ObjectManager $manager): void
    {
        $lgBrand = new Brand();
        $lgBrand->setName('LG');
        $manager->persist($lgBrand);
        $this->addReference(self::LG_BRAND_REFERENCE, $lgBrand);
    }
    
    private function registerMotorola(ObjectManager $manager): void
    {
        $motorolaBrand = new Brand();
        $motorolaBrand->setName('Motorola');
        $manager->persist($motorolaBrand);
        $this->addReference(self::MOTOROLA_BRAND_REFERENCE, $motorolaBrand);
    }
}
