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
                'name' => 'Toto'
            ],
            2 => [
                'name' => 'John Doe'
            ],
            3 => [
                'name' => 'Isaac Asimov'
            ],
            4 => [
                'name' => 'J. K. Rowling'
            ],
            5 => [
                'name' => 'Anne de Kinkelin'
            ],
            6 => [
                'name' => 'Anne-Gaëlle Huon'
            ],
            7 => [
                'name' => 'Valérie Perrin'
            ],
            8 => [
                'name' => 'Marc Dugain'
            ],
            9 => [
                'name' => 'Hervé Le Tellier'
            ],
            10 => [
                'name' => 'Adeline Dieudonné'
            ],
            11 => [
                'name' => 'Emilie Besse'
            ],
            12 => [
                'name' => 'Delphine de Vigan'
            ],
            13 => [
                'name' => 'Agnès Martin-Lugand'
            ],
            14 => [
                'name' => 'Édouard Louis'
            ],
            15 => [
                'name' => 'Adèle Bréau'
            ],
            16 => [
                'name' => 'Adélaïde de Clermont-Tonnerre'
            ],
            17 => [
                'name' => 'Sophie Henrionnet'
            ],
            18 => [
                'name' => 'Katja Lasan'
            ],
            19 => [
                'name' => 'Mélissa Da Costa'
            ],
            20 => [
                'name' => 'Emily Blaine'
            ],
            21 => [
                'name' => 'Franck Thilliez'
            ],
            22 => [
                'name' => 'Antoine Cristau'
            ],
            23 => [
                'name' => 'Rudo'
            ],
            24 => [
                'name' => 'Valentin Musso'
            ],
            25 => [
                'name' => 'Julien Rampin'
            ],
            26 => [
                'name' => 'Magne Hovden'
            ],
            27 => [
                'name' => 'Olivier Bourdeaut'
            ],
            28 => [
                'name' => 'Baptiste Beaulieu'
            ],
            29 => [
                'name' => 'Aurélie Valognes'
            ],
            30 => [
                'name' => 'Elena Ferrante'
            ],
            31 => [
                'name' => 'Gaël Faye'
            ],
            32 => [
                'name' => 'Nicolas Mathieu'
            ],
            33 => [
                'name' => 'Pierre Lemaitre'
            ],
        ];

        foreach ($author as $key => $value) {
            $author = new Author();
            $author->setName($value['name']);
            $manager->persist($author);
        }
        
        $manager->flush();
    }
}
