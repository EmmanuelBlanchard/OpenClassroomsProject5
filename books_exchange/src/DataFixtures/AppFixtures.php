<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
    
    public function getDependencies()
    {
        return [
            AuthorFixtures::class,
            CategoryFixtures::class,
            PublisherFixtures::class,
            LanguageFixtures::class,
            FormatFixtures::class,
            StateFixtures::class,
            UserFixtures::class,
            BookFixtures::class,
        ];
    }
}
