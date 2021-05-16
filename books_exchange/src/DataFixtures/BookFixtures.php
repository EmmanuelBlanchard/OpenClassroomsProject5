<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $book = [
            1 => [
                'title' => 'Le Cycle de Fondation, tome 1 : Fondation',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            2 => [
                'title' => 'Le Cycle de Fondation, tome 2 : Fondation et Empire',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            3 => [
                'title' => 'Le Cycle de Fondation, tome 3 : Seconde Fondation',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            4 => [
                'title' => 'Le Cycle de Fondation, tome 4 : Fondation foudroyée',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            5 => [
                'title' => 'Le Cycle de Fondation, Tome 5 : Terre et Fondation',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            6 => [
                'title' => 'Le Cycle de Fondation, tome 6 : Prélude à Fondation',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            7 => [
                'title' => 'Le Cycle de Fondation, tome 7 : L\'aube de Fondation',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            8 => [
                'title' => 'Harry Potter, tome 1 : Harry Potter à l\'Ecole des Sorciers',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            9 => [
                'title' => 'Harry Potter, tome 2 : Harry Potter et la Chambre des Secrets',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            10 => [
                'title' => 'Harry Potter, tome 3 : Harry Potter et le Prisonnier d\'Azkaban',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            11 => [
                'title' => 'Harry Potter, tome 4 : Harry Potter et la Coupe de Feu',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            12 => [
                'title' => 'Harry Potter, tome 5 : Harry Potter et l\'Ordre du Phénix',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            13 => [
                'title' => 'Harry Potter, tome 6 : Harry Potter et le Prince de sang mêlé',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            14 => [
                'title' => 'Harry Potter, tome 7 : Harry Potter et les reliques de la mort',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            15 => [
                'title' => 'Ce que les étoiles doivent à la nuit',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            16 => [
                'title' => 'Changer l\'eau des fleurs',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            17 => [
                'title' => 'Les enfants sont rois',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            18 => [
                'title' => 'La sourde oreille',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            19 => [
                'title' => 'L\'anomalie',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            20 => [
                'title' => 'La chambre des officiers',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            21 => [
                'title' => 'Les beaux jours',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            22 => [
                'title' => 'Trois',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            23 => [
                'title' => 'Kérozène',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            24 => [
                'title' => 'La Datcha',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            25 => [
                'title' => 'Combats et métamorphoses d\'une femme',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            26 => [
                'title' => 'Haute saison',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            27 => [
                'title' => 'Les jours heureux',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            28 => [
                'title' => 'Plus immortelle que moi',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            29 => [
                'title' => '24 heures',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            30 => [
                'title' => 'Tout le bleu du ciel',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            31 => [
                'title' => 'Un peu plus d\'amour que d\'ordinaire',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            32 => [
                'title' => '1991',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            33 => [
                'title' => 'Fête et défaites',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            34 => [
                'title' => 'Fête et défaites',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            35 => [
                'title' => 'Prends bien soin de toi !',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            36 => [
                'title' => 'Qu\'à jamais j\'oublie',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            37 => [
                'title' => 'Grandir un peu',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            38 => [
                'title' => 'La vie est un cirque',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            39 => [
                'title' => 'Florida',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            40 => [
                'title' => 'Celle qu\'il attendait',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            41 => [
                'title' => 'Le tourbillon de la vie',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            42 => [
                'title' => 'L\'amie prodigieuse, tome 1 : Enfance, adolescence',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            43 => [
                'title' => 'Petit pays',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            44 => [
                'title' => 'Leurs enfants après eux',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],
            45 => [
                'title' => 'Au revoir là-haut',
                'active' => true,
                'summary' => '',
                'setExchangeRequest' => false,
            ],

        ];

        foreach ($book as $key => $value) {
            $book = new Book();
            
            $book->setTitle($value['title']);
            $book->setActive($value['active']);
            $book->setSummary($value['summary']);
            $book->setExchangeRequest($value['setExchangeRequest']);

            $manager->persist($book);
        }
        
        $manager->flush();
    }
}
