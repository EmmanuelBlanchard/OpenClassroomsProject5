<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $author = [
            1 => [
                'name' => 'Isaac Asimov'
            ],
            2 => [
                'name' => 'J. K. Rowling'
            ],
        ];

        foreach($author as $key => $value) {
            $author = new Author();
            $author->setName($value['name']);
            $manager->persist($author);
        }
        
        $manager->flush();
    }
}
