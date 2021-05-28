<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Factory\BookFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        BookFactory::new()->create(20);
        
        $manager->flush();
    }
}
