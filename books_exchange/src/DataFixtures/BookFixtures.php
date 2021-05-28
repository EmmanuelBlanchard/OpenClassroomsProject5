<?php

namespace App\DataFixtures;

use App\Factory\BookFactory;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        BookFactory::new()->create(20);
        
        $manager->flush();
    }
}
