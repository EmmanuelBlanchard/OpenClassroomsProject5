<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\DataFixtures\BaseFixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends BaseFixture
{
    private static $bookAuthor = [
        'Toto',
        'John Doe',
        'Isaac Asimov',
        'J. K. Rowling',
        'Anne de Kinkelin',
        'Anne-Gaëlle Huon',
        'Valérie Perrin',
        'Marc Dugain',
        'Hervé Le Tellier',
        'Adeline Dieudonné',
        'Emilie Besse',
        'Delphine de Vigan',
        'Agnès Martin-Lugand',
        'Édouard Louis',
        'Adèle Bréau',
        'Adélaïde de Clermont-Tonnerre',
        'Sophie Henrionnet',
        'Katja Lasan',
        'Mélissa Da Costa',
        'Emily Blaine',
        'Franck Thilliez',
        'Antoine Cristau',
        'Rudo',
        'Valentin Musso',
        'Julien Rampin',
        'Magne Hovden',
        'Olivier Bourdeaut',
        'Baptiste Beaulieu',
        'Aurélie Valognes',
        'Elena Ferrante',
        'Gaël Faye',
        'Nicolas Mathieu',
        'Pierre Lemaitre',
        'Autre',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Author::class, 33, function (Author $author, $count) use ($manager) {
            $author->setName($this->faker->randomElement(self::$bookAuthor));
            
            $manager->persist($author);
        });

        $manager->flush();
    }
}
